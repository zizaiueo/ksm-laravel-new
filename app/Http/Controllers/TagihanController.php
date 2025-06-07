<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Tagihan;
use App\Models\Pembayaran;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode');
        $editMode = $request->has('edit');
        $tarifPerM3 = 5000;

        $pelanggans = Pelanggan::all();
        $data = [];

        foreach ($pelanggans as $pelanggan) {
            $pemakaian = Pemakaian::where('pelanggan_id', $pelanggan->id)
                        ->where('periode', $periode)
                        ->first();

            $tagihan = Tagihan::where('pelanggan_id', $pelanggan->id)
                        ->where('periode', $periode)
                        ->first();

            $data[] = [
                'pelanggan' => $pelanggan,
                'meter_awal' => $pemakaian->meter_awal ?? null,
                'meter_akhir' => $pemakaian->meter_akhir ?? null,
                'tarif' => 5000,
                'jumlah_tagihan' => $tagihan->jumlah_tagihan ?? null,
            ];
        }

        return view('tagihan.index', compact('data', 'periode', 'editMode'));
    }

    public function generateAll(Request $request)
    {
        $periode = $request->input('periode');
        if (!$periode) {
            return redirect()->route('tagihan.index')->with('error', 'Periode tidak boleh kosong.');
        }

        $dataPemakaian = Pemakaian::with('pelanggan')
            ->where('periode', $periode)
            ->get();

        $tarif = 5000;

        foreach ($dataPemakaian as $pemakaian) {
            if ($pemakaian->meter_awal === null || $pemakaian->meter_akhir === null) {
                continue;
            }

            $totalPemakaian = $pemakaian->meter_akhir - $pemakaian->meter_awal;

            if ($totalPemakaian < 0) {
                continue;
            }

            Tagihan::updateOrCreate(
                [
                    'pelanggan_id' => $pemakaian->pelanggan_id,
                    'periode' => $periode,
                ],
                [
                    'jumlah_pemakaian' => $totalPemakaian,
                    'tarif_per_m3' => $tarif,
                    'jumlah_tagihan' => $totalPemakaian * $tarif,
                ]
            );
        }

        return redirect()->route('tagihan.index', ['periode' => $periode])
            ->with('success', 'Tagihan berhasil digenerate untuk periode ' . $periode);
    }
}