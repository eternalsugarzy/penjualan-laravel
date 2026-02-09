<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ReturnSupplierController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// --- ROUTE AUTH (LOGIN/LOGOUT) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- GRUP ROUTE YANG BUTUH LOGIN (MIDDLEWARE AUTH) ---
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Resource (Otomatis buat index, create, store, edit, update, destroy)
    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('bank', BankController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::resource('return', ReturnSupplierController::class);
    Route::resource('user', UserController::class); 

    // --- PENGATURAN TOKO (PERBAIKAN DISINI) ---
    Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');
    // Baris di bawah ini yang sebelumnya hilang:
    Route::put('/toko', [TokoController::class, 'update'])->name('toko.update'); 

    // --- KASIR / TRANSAKSI ---
    Route::get('/kasir', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/kasir/order', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/kasir/print/{id}', [TransaksiController::class, 'print'])->name('transaksi.print');
    Route::get('/kasir/riwayat', [TransaksiController::class, 'history'])->name('transaksi.history');
    Route::get('/kasir/nota/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/cetak/{id}', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

});