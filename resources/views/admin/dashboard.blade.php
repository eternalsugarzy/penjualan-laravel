@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Ringkasan Bisnis')

@section('content')

{{-- Swiper CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<div class="space-y-6">
    {{-- 1. SECTION WELCOME BANNER (VERSI MINI) --}}
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl p-4 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center px-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-400/20 rounded-xl flex items-center justify-center text-amber-400">
                    <i class="fas fa-user-shield text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-amber-400 leading-none">Halo, {{ Auth::user()->nama }}! 👋</h1>
                    <p class="text-slate-400 text-xs mt-1">Selamat datang kembali di Panel Produk Daur Ulang.</p>
                </div>
            </div>
            <div class="mt-3 md:mt-0">
                <a href="{{ route('transaksi.index') }}" class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-500 transition shadow-md">
                    <i class="fas fa-shopping-cart mr-1"></i> Kelola Penjualan
                </a>
            </div>
        </div>
        {{-- Hiasan transparan yang lebih kecil --}}
        <i class="fas fa-recycle absolute -right-4 -bottom-4 text-6xl text-white opacity-5"></i>
    </div>

    {{-- 3. SECTION STATISTIK (SEBARIS) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center"><i class="fas fa-boxes"></i></div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold uppercase">Produk</p>
                <h3 class="text-lg font-black text-slate-800">{{ $total_produk }}</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center"><i class="fas fa-exchange-alt"></i></div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold uppercase">Transaksi</p>
                <h3 class="text-lg font-black text-slate-800">{{ $total_transaksi }}</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center"><i class="fas fa-truck"></i></div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold uppercase">Supplier</p>
                <h3 class="text-lg font-black text-slate-800">{{ $total_supplier }}</h3>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center"><i class="fas fa-th-list"></i></div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold uppercase">Kategori</p>
                <h3 class="text-lg font-black text-slate-800">{{ $total_kategori }}</h3>
            </div>
        </div>
    </div>

    {{-- 2. CAROUSEL LANDSCAPE (LEBIH BESAR & DOMINAN) --}}
    <div class="swiper mySwiper rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="swiper-wrapper">
            <div class="swiper-slide relative h-[450px]">
                <img src="{{ asset('img/carousel1.jpeg') }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/1200x500?text=Foto+1+Belum+Ada'">
                <div class="absolute bottom-0 left-0 w-full p-10 bg-gradient-to-t from-black/80 via-black/40 to-transparent text-white">
                    <h3 class="text-2xl font-black uppercase tracking-tight">Lokasi Workshop PKL</h3>
                    <p class="text-slate-200 text-sm opacity-90">Dinas Lingkungan Hidup Kota Banjarmasin</p>
                </div>
            </div>
            <div class="swiper-slide relative h-[450px]">
                <img src="{{ asset('img/carousel2.jpeg') }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/1200x500?text=Foto+2+Belum+Ada'">
                <div class="absolute bottom-0 left-0 w-full p-10 bg-gradient-to-t from-black/80 via-black/40 to-transparent text-white">
                    <h3 class="text-2xl font-black uppercase tracking-tight">Lokasi Workshop PKL</h3>
                    <p class="text-slate-200 text-sm opacity-90">Dinas Lingkungan Hidup Kota Banjarmasin</p>
                </div>
            </div>
            <div class="swiper-slide relative h-[450px]">
                <img src="{{ asset('img/carousel3.jpeg') }}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/1200x500?text=Foto+3+Belum+Ada'">
                <div class="absolute bottom-0 left-0 w-full p-10 bg-gradient-to-t from-black/80 via-black/40 to-transparent text-white">
                    <h3 class="text-2xl font-black uppercase tracking-tight">Lokasi Workshop PKL</h3>
                    <p class="text-slate-200 text-sm opacity-90">Dinas Lingkungan Hidup Kota Banjarmasin</p>
                </div>
            </div>
        </div>
        <div class="swiper-button-next !text-white !after:text-xl bg-black/30 hover:bg-black/50 w-10 h-10 rounded-full backdrop-blur-md transition"></div>
        <div class="swiper-button-prev !text-white !after:text-xl bg-black/30 hover:bg-black/50 w-10 h-10 rounded-full backdrop-blur-md transition"></div>
        <div class="swiper-pagination"></div>
    </div>

    

    {{-- 4. VISI MISI --}}
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
            <h3 class="text-sm font-black text-blue-600 uppercase tracking-widest mb-2">Visi</h3>
            <p class="text-slate-700 font-serif italic text-lg leading-relaxed border-l-4 border-blue-500 pl-4">
                "Terwujudnya Pembangunan yang Berkelanjutan dan Berwawasan Lingkungan Hidup Menuju Banjarmasin Bersih, Indah dan Nyaman."
            </p>
        </div>
        <div>
            <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest mb-2">Misi Utama</h3>
            <ul class="text-sm text-slate-600 space-y-2">
                <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-[10px]"></i>Mencegah, mengendalikan, dan pemulihan pencemaran air, udara, dan
tanah serta mendukung terpeliharanya kelestarian fungsi lingkungan hidup</li>
                <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-[10px]"></i>Mengembangkan sistem data dan informasi kondisi lingkungan hidup.</li>
                <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-[10px]"></i>Menciptakan kota Banjarmasin yang bersih, indah, dan nyaman serta
terbangunnya taman-taman kota dan ruang terbuka hijau</li>
                <li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-[10px]"></i>Pengembangan kapasitas sumber daya manusia yang berwawasan
lingkungan.</li>
            </ul>
        </div>
    </div>
</div>

{{-- Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    });
</script>

<style>
    .swiper-pagination-bullet-active { background: #2563eb !important; width: 20px !important; border-radius: 4px !important; }
</style>

@endsection