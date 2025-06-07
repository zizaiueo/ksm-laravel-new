<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Pemakaian;
use PDF;

class LaporanController extends Controller
{
    // Data Pelanggan
    public function pelangganList()
    {
        $pelanggans = Pelanggan::all();
        return view('laporan.pelanggan.list', compact('pelanggans'));
    }

    public function pelangganCetak()
    {
        $pelanggans = Pelanggan::all();
        $pdf = PDF::loadView('laporan.pelanggan.cetak', compact('pelanggans'));
        return $pdf->stream('laporan_pelanggan_'.date('Ymd').'.pdf');
    }

    // Data Tagihan
public function tagihan(Request $request)
{
    $periode = $request->query('periode');
    $tagihans = collect();

    if ($periode) {
        $tagihans = Tagihan::with(['pelanggan', 'pemakaian'])
            ->where('periode', $periode)
            ->get();

        // Filter pemakaian sesuai periode dan simpan di atribut sementara
        foreach ($tagihans as $tagihan) {
            $tagihan->pemakaian_filtered = $tagihan->pemakaian->firstWhere('periode', $tagihan->periode);
        }
    }

    return view('laporan.tagihan.index', compact('periode', 'tagihans'));
}

public function tagihanCetak(Request $request)
{
    $periode = $request->query('periode');
    $tagihans = collect();

    if ($periode) {
        $tagihans = Tagihan::with(['pelanggan', 'pemakaian'])
            ->where('periode', $periode)
            ->get();

        foreach ($tagihans as $tagihan) {
            $tagihan->pemakaian_filtered = $tagihan->pemakaian->firstWhere('periode', $tagihan->periode);
        }
    }

    $pdf = PDF::loadView('laporan.tagihan.cetak', compact('tagihans', 'periode'));
    return $pdf->stream("laporan_tagihan_{$periode}.pdf");
}


    // Data Pembayaran
public function pembayaran(Request $request)
{
    $periode = $request->query('periode');
    $pembayarans = collect();

    if ($periode) {
        $pembayarans = Pembayaran::with([
            'pelanggan',
            'pemakaian' => function ($query) use ($periode) {
                $query->where('periode', $periode);
            },
            'tagihan' => function ($query) use ($periode) {
                $query->where('periode', $periode);
            }
        ])
        ->where('periode', $periode)
        ->get();
    }

    return view('laporan.pembayaran.index', compact('periode', 'pembayarans'));
}



public function pembayaranCetak()
{
    $periode = request('periode');
    $query = Pembayaran::with(['pelanggan', 'pemakaian', 'tagihan']);

    if ($periode) {
        $query->where('periode', $periode);
    }

    $pembayarans = $query->get();

    $pdf = PDF::loadView('laporan.pembayaran.cetak', compact('pembayarans', 'periode'));
    return $pdf->stream('laporan_pembayaran_' . ($periode ?? 'semua') . '_' . date('Ymd') . '.pdf');
}
}
