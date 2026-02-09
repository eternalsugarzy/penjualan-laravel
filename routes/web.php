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

Route::get('/', function () {
    return redirect('/login');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Tambahkan ini!
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- GRUP KHUSUS ADMIN ---
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('produk', ProdukController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('supplier', SupplierController::class);
Route::resource('bank', BankController::class);
Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');

Route::get('/kasir', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/kasir/order', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/kasir/print/{id}', [TransaksiController::class, 'print'])->name('transaksi.print');
Route::get('/kasir/riwayat', [TransaksiController::class, 'history'])->name('transaksi.history');
Route::get('/kasir/nota/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');