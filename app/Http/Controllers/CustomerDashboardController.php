<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        return view('customer.dashboard', compact('user','pelanggan'));
    }
}