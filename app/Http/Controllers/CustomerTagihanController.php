<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Tagihan;

class CustomerTagihanController extends Controller
{
    public function index()
    {
        $username = Auth::user()->username;

        $pelanggan = Pelanggan::where('no_hp', $username)->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        // Ambil semua tagihan untuk pelanggan ini
        $tagihans = Tagihan::where('pelanggan_id', $pelanggan->id)->orderBy('periode', 'desc')->get();

        // Ambil juga data pemakaian untuk disesuaikan
        $pemakaians = Pemakaian::where('pelanggan_id', $pelanggan->id)->get()->keyBy('periode');

        return view('customer.tagihan', compact('pelanggan', 'tagihans', 'pemakaians'));
    }
}
