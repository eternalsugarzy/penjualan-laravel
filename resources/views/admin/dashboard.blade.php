@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Ringkasan Bisnis')

@section('content')

<div class="mt-2 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm relative overflow-hidden">
    <div class="relative z-10">
        <div class="p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transform transition hover:scale-[1.03]">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 text-xl">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <p class="text-slate-500 text-xs font-bold uppercase">Total Produk</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $total_produk }}</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transform transition hover:scale-[1.03]">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 text-xl">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <p class="text-slate-500 text-xs font-bold uppercase">Transaksi</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $total_transaksi }}</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transform transition hover:scale-[1.03]">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4 text-xl">
                        <i class="fas fa-truck"></i>
                    </div>
                    <p class="text-slate-500 text-xs font-bold uppercase">Suppliers</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $total_supplier }}</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transform transition hover:scale-[1.03]">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-4 text-xl">
                        <i class="fas fa-th-list"></i>
                    </div>
                    <p class="text-slate-500 text-xs font-bold uppercase">Kategori</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $total_kategori }}</h3>
                </div>
            </div>

            <div class="mt-8 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl shadow-blue-200">
                <h1 class="text-3xl font-bold">Halo, {{ Auth::user()->nama }}! 👋</h1>
                <p class="mt-2 text-blue-100 opacity-90 max-w-xl">
                    Senang melihat Anda kembali. Hari ini ada {{ $total_transaksi }} transaksi yang masuk ke sistem. Pantau terus laporan penjualan harian untuk hasil yang maksimal!
                </p>
                <div class="mt-6 flex space-x-4">
                    <button class="bg-white text-blue-600 px-6 py-2 rounded-xl font-bold hover:bg-blue-50 transition">Lihat Laporan</button>
                    <button class="bg-blue-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-400 transition border border-blue-400">Tambah Produk</button>
                </div>
            </div>
        </div>
    </div>
    <i class="fas fa-chart-line absolute -right-10 -bottom-10 text-[200px] text-slate-50 opacity-5"></i>
</div>
@endsection

       