<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerTagihanController;
use App\Http\Controllers\CustomerPembayaranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// --- ROUTE ADMIN ---

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Auth Login dan Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Data Pelanggan
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create'); // optional kalau pakai form create terpisah
Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');


// Kelola Pemakaian Air
Route::get('/pemakaian', [PemakaianController::class, 'index'])->name('pemakaian.index');
Route::post('/pemakaian/save', [PemakaianController::class, 'save'])->name('pemakaian.save');


// Kelola Tagihan
Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
Route::post('/tagihan/generateAll',[TagihanController::class,'generateAll'])->name('tagihan.generateAll');

// Kelola Pembayaran
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::post('/pembayaran/update',[PembayaranController::class,'update'])->name('pembayaran.update');

// Cetak Laporan
Route::get('/laporan/pelanggan', [LaporanController::class, 'pelangganList'])->name('laporan.pelanggan.list');
Route::get('/laporan/pelanggan/cetak', [LaporanController::class, 'pelangganCetak'])->name('laporan.pelanggan.cetak');
Route::get('/laporan/pemakaian', [LaporanController::class, 'pemakaian'])->name('laporan.pemakaian.index');
Route::get('/laporan/pemakaian/cetak', [LaporanController::class, 'pemakaianCetak'])->name('laporan.pemakaian.cetak');
Route::get('/laporan/pembayaran', [LaporanController::class, 'pembayaran'])->name('laporan.pembayaran.index');
Route::get('/laporan/pembayaran/cetak', [LaporanController::class, 'pembayaranCetak'])->name('laporan.pembayaran.cetak');
Route::get('/laporan/tagihan', [LaporanController::class, 'tagihan'])->name('laporan.tagihan.index');
Route::get('/laporan/tagihan/cetak', [LaporanController::class, 'tagihanCetak'])->name('laporan.tagihan.cetak');





// --- ROUTE CUSTOMER ---

Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/tagihan', [CustomerTagihanController::class, 'index'])->name('customer.tagihan');
    Route::get('/pembayaran', [CustomerPembayaranController::class, 'index'])->name('customer.pembayaran');
    Route::post('/kirim/{id}', [CustomerPembayaranController::class, 'kirim'])->name('customer.kirim');
    Route::get('/list-buktibayar', [CustomerPembayaranController::class, 'listBayar'])->name('customer.list-buktibayar');
    Route::get('/cetak-buktibayar/{id}', [CustomerPembayaranController::class, 'cetak'])->name('customer.cetak-buktibayar');
});

