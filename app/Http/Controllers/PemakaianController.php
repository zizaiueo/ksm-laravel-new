<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Pemakaian;

class PemakaianController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->query('periode');
        $editMode = $request->query('edit') === '1';

        $data = collect();

        if ($periode) {
            $pelanggans = Pelanggan::all();

            $data = $pelanggans->map(function($pelanggan) use ($periode) {
                $pemakaian = Pemakaian::where('pelanggan_id', $pelanggan->id)
                    ->where('periode', $periode)
                    ->first();

                if (!$pemakaian) {
                    $pemakaian = (object)[
                        'meter_awal' => 0,
                        'meter_akhir' => null,
                    ];
                }

                return [
                    'pelanggan' => $pelanggan,
                    'pemakaian' => $pemakaian,
                ];
            });
        }

        return view('pemakaian.index', compact('periode', 'data', 'editMode'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'pemakaian' => 'required|array',
        ]);

        $periode = $request->periode;
        $inputPemakaian = $request->pemakaian;

        foreach ($inputPemakaian as $pelangganId => $values) {
            $meter_awal = $values['meter_awal'] ?? 0;
            $meter_akhir = $values['meter_akhir'] ?? null;

            $total_pemakaian = ($meter_akhir !== null && $meter_akhir !== '') ? max(0, $meter_akhir - $meter_awal) : 0;

            Pemakaian::updateOrCreate(
                ['pelanggan_id' => $pelangganId, 'periode' => $periode],
                [
                    'meter_awal' => $meter_awal,
                    'meter_akhir' => $meter_akhir,
                    'total_pemakaian' => $total_pemakaian,
                ]
            );
        }

        return redirect()->route('pemakaian.index', ['periode' => $periode])
            ->with('success', 'Data pemakaian berhasil disimpan.');
    }
}
