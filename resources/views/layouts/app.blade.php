<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- BAGIAN INI UNTUK MENGGANTI IKON BOLA DUNIA DI TAB BROWSER --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/png">

    <title>@yield('title') | PEMASARAN PRODUK DAUR ULANG</title>
    
    {{-- CDN Scripts & Styles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Font Google --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    {{-- 1. SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- 2. KONTEN UTAMA --}}
    <div class="flex-1 flex flex-col min-w-0">
        
        {{-- HEADER ATAS --}}
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sticky top-0 z-30 shadow-sm">
            
            {{-- KIRI: Judul Halaman --}}
            <div class="flex items-center gap-3">
                <h2 class="font-bold text-lg text-slate-800 tracking-tight pl-2 border-l-4 border-blue-600">
                    @yield('header')
                </h2>
            </div>

            {{-- KANAN: Profil User --}}
            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block leading-tight">
                    <p class="text-sm font-bold text-slate-700">{{ Auth::user()->nama }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ Auth::user()->level ?? 'User' }}</p>
                </div>
                
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama }}&background=2563eb&color=fff&bold=true" 
                         class="w-9 h-9 rounded-full border-2 border-white shadow-md ring-1 ring-slate-100">
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
            </div>
        </header>

        {{-- AREA KONTEN --}}
        <main class="flex-1 overflow-y-auto p-6 scroll-smooth">
            @yield('content')
        </main>
        
    </div>

</body>
</html>