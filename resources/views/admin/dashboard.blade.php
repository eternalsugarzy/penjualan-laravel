@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Ringkasan Bisnis')

@section('content')

{{-- 1. SECTION WELCOME BANNER --}}
<div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-3xl p-8 text-white shadow-xl shadow-slate-200 relative overflow-hidden mb-6">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold text-amber-400">Halo, {{ Auth::user()->nama ?? 'Admin' }}! 👋</h1>
            <p class="mt-2 text-slate-300 max-w-xl leading-relaxed">
                Selamat datang kembali di Panel Admin <b>Pemasaran Produk Daur Ulang</b>. 
                Pantau performa penjualan hari ini dan kelola inventaris dengan lebih mudah.
            </p>
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('transaksi.index') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-blue-500 transition shadow-lg shadow-blue-900/50">
                    <i class="fas fa-shopping-cart mr-2"></i> Kelola Penjualan
                </a>
            </div>
        </div>
        {{-- Hiasan Icon Besar Transparan --}}
        <div class="hidden md:block opacity-10 transform rotate-12">
            <i class="fas fa-recycle text-9xl text-white"></i>
        </div>
    </div>
</div>

{{-- 2. SECTION STATISTIK --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Card Produk --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Produk</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $total_produk }}</h3>
            </div>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>

    {{-- Card Transaksi --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Transaksi</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $total_transaksi }}</h3>
            </div>
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition">
                <i class="fas fa-exchange-alt"></i>
            </div>
        </div>
    </div>

    {{-- Card Supplier --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Suppliers</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $total_supplier }}</h3>
            </div>
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>

    {{-- Card Kategori --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Kategori</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $total_kategori }}</h3>
            </div>
            <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition">
                <i class="fas fa-th-list"></i>
            </div>
        </div>
    </div>
</div>

{{-- 3. SECTION VISI MISI & FOTO --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    {{-- Kolom Kiri: Foto --}}
    <div class="relative w-full h-full min-h-[250px] rounded-2xl overflow-hidden group">
    
    {{-- BAGIAN INI YANG DIUBAH --}}
    <img src="{{ asset('img/tempatPKL.jpeg') }}" 
         alt="Foto Usaha" 
         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700"
         onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Foto+Tidak+Ditemukan'">
    
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
        <div class="text-white">
            <p class="text-sm font-light opacity-90">Lokasi PKL</p>
            <h3 class="font-bold text-lg"></h3>
        </div>
    </div>
</div>

    {{-- Kolom Kanan: Visi & Misi --}}
    <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-center">
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-eye text-sm"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-wide">Visi Kami</h3>
            </div>
            <p class="text-slate-600 leading-relaxed italic border-l-4 border-blue-500 pl-4">
                “Terwujudnya Pembangunan yang Berkelanjutan dan Berwawasan Lingkungan Hidup Menuju Banjarmasin Bersih, Indah dan Nyaman."
            </p>
        </div>

        <div>
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-bullseye text-sm"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-wide">Misi Kami</h3>
            </div>
            <ul class="space-y-3">
                <li class="flex items-start text-slate-600">
                    <i class="fas fa-check-circle text-emerald-500 mt-1 mr-3"></i>
                    <span>Mencegah, mengendalikan, dan pemulihan pencemaran air, udara, dan tanah serta mendukung terpeliharanya kelestarian fungsi lingkungan hidup.</span>
                </li>
                <li class="flex items-start text-slate-600">
                    <i class="fas fa-check-circle text-emerald-500 mt-1 mr-3"></i>
                    <span>Mengembangkan sistem data dan informasi kondisi lingkungan hidup.</span>
                </li>
                <li class="flex items-start text-slate-600">
                    <i class="fas fa-check-circle text-emerald-500 mt-1 mr-3"></i>
                    <span>Menciptakan kota Banjarmasin yang bersih, indah, dan nyaman serta terbangunnya taman-taman kota dan ruang terbuka hijau.</span>
                </li>
                <li class="flex items-start text-slate-600">
                    <i class="fas fa-check-circle text-emerald-500 mt-1 mr-3"></i>
                    <span>Pengembangan kapasitas sumber daya manusia yang berwawasan lingkungan.</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection