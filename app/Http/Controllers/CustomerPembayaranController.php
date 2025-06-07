<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use PDF;

class CustomerPembayaranController extends Controller
{
    public function index()
    {
        $no_hp = Auth::user()->username;

        $tagihans = Tagihan::with(['pemakaian', 'pembayaran', 'pelanggan'])
            ->whereHas('pelanggan', function ($q) use ($no_hp) {
                $q->where('no_hp', $no_hp);
            })
            ->get();

        return view('customer.pembayaran', compact('tagihans'));
    }

    public function kirim(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'metode' => 'required|in:online,offline',
            'transaksi_sn' => 'nullable|string|max:255',
        ]);

        // Ambil data tagihan dan pelanggan terkait
        $tagihan = Tagihan::with('pelanggan')->findOrFail($id);
        $pelanggan = $tagihan->pelanggan;

        if (!$pelanggan) {
            return back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $periode = $tagihan->periode;

        // Kunci unik untuk menentukan apakah pembayaran sudah pernah dibuat
        $pembayaranKey = [
            'pelanggan_id' => $pelanggan->id,
            'periode' => $periode,
        ];

        // Data yang akan disimpan atau diupdate
        $pembayaranData = [
            'status' => 'pending',
            'tanggal_bayar' => null, // Admin akan input manual
            'metode' => $request->metode,
            'transaksi_sn' => $request->metode === 'online'
                ? $request->no_transaksi
                : '-', // default untuk offline
        ];

        // Simpan atau update pembayaran
        Pembayaran::updateOrCreate($pembayaranKey, $pembayaranData);

        // Beri notifikasi balik ke customer
        return back()->with(
            $request->metode === 'online' ? 'success' : 'info',
            $request->metode === 'online'
                ? 'Pembayaran online telah dikirim, mohon tunggu admin memverifikasi.'
                : 'Permintaan pembayaran offline telah dikirim, mohon tunggu admin menuju lokasi.'
        );
    }


    public function listBayar()
    {
        $user = auth()->user();

        $pembayarans = \App\Models\Pembayaran::with('pelanggan')
            ->whereHas('pelanggan', function ($q) use ($user) {
                $q->where('no_hp', $user->username);
            })
            ->orderBy('periode', 'desc')
            ->get();

        // Ambil tagihan untuk setiap pembayaran berdasarkan pelanggan & periode
        foreach ($pembayarans as $pembayaran) {
            $pembayaran->tagihan = \App\Models\Tagihan::where('pelanggan_id', $pembayaran->pelanggan_id)
                ->where('periode', $pembayaran->periode)
                ->first();
        }

        return view('customer.list-buktibayar', compact('pembayarans'));
    }


    public function cetak($id)
    {
        $user = auth()->user();

    $pembayaran = \App\Models\Pembayaran::with('pelanggan')
        ->where('id', $id)
        ->whereHas('pelanggan', function ($q) use ($user) {
            $q->where('no_hp', $user->username);
        })
        ->firstOrFail();

    $tagihan = \App\Models\Tagihan::where('pelanggan_id', $pembayaran->pelanggan_id)
        ->where('periode', $pembayaran->periode)
        ->first();

    $pdf = PDF::loadView('customer.cetak-buktibayar', compact('pembayaran', 'tagihan'))
        ->setPaper('A5', 'portrait');

    return $pdf->stream('bukti_pembayaran_'.$pembayaran->id.'.pdf');
    }
}
