<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Tagihan;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode');
        $editMode = $request->input('edit') == 1;

        $data = collect();

        if ($periode) {
            $pelanggans = Pelanggan::all();

            $data = $pelanggans->map(function ($pelanggan) use ($periode) {
                $pemakaian = Pemakaian::where('pelanggan_id', $pelanggan->id)
                    ->where('periode', $periode)
                    ->first();

                $tagihan = Tagihan::where('pelanggan_id', $pelanggan->id)
                    ->where('periode', $periode)
                    ->first();

                $pembayaran = Pembayaran::where('pelanggan_id', $pelanggan->id)
                    ->where('periode', $periode)
                    ->first();

                if (!$pemakaian) {
                    $pemakaian = (object)[
                        'meter_awal' => 0,
                        'meter_akhir' => null,
                        'total_pemakaian' => 0,
                    ];
                } else {
                    $pemakaian->total_pemakaian = $pemakaian->meter_akhir !== null && $pemakaian->meter_awal !== null
                        ? $pemakaian->meter_akhir - $pemakaian->meter_awal
                        : 0;
                }

                return [
                    'pelanggan' => $pelanggan,
                    'pemakaian' => $pemakaian,
                    'tagihan' => $tagihan,
                    'pembayaran' => $pembayaran,
                ];
            });
        }

        return view('pembayaran.index', compact('periode', 'data', 'editMode'));
    }

    public function update(Request $request)
    {
        $periode = $request->input('periode');
        $pembayarans = $request->input('pembayarans');

        foreach ($pembayarans as $pelangganId => $pembayaranData) {
            $existing = Pembayaran::where('pelanggan_id', $pelangganId)
                ->where('periode', $periode)
                ->first();

            $dataToUpdate = [];

            // Hanya update status jika inputnya valid dan berbeda dari data lama
            if (array_key_exists('status', $pembayaranData) && $pembayaranData['status'] !== '') {
                // Optional: cek jika status input sama dengan status lama, gak usah update
                if (!$existing || $existing->status !== $pembayaranData['status']) {
                    $dataToUpdate['status'] = $pembayaranData['status'];
                }
            } else {
                // Jika status tidak dikirim, pertahankan status lama
                if ($existing) {
                    $dataToUpdate['status'] = $existing->status;
                }
            }

            // Update tanggal bayar hanya jika diisi
            if (array_key_exists('tanggal_bayar', $pembayaranData) && $pembayaranData['tanggal_bayar'] !== '') {
                $dataToUpdate['tanggal_bayar'] = $pembayaranData['tanggal_bayar'];
            } else {
                // Pertahankan tanggal bayar lama jika ada
                if ($existing) {
                    $dataToUpdate['tanggal_bayar'] = $existing->tanggal_bayar;
                }
            }

            // Metode tidak boleh diubah admin, ambil dari DB jika ada
            if ($existing) {
                $dataToUpdate['metode'] = $existing->metode ?? '-';
            } else {
                $dataToUpdate['metode'] = $pembayaranData['metode'] ?? '-';
            }

            Pembayaran::updateOrCreate(
                ['pelanggan_id' => $pelangganId, 'periode' => $periode],
                $dataToUpdate
            );
        }

        return redirect()->back()->with('success', 'Data pembayaran berhasil diperbarui.');
    }
}