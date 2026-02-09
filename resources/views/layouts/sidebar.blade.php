<aside class="w-64 bg-slate-900 min-h-screen sticky top-0 text-slate-300 flex flex-col shadow-2xl">
    
    <div class="p-6 border-b border-slate-800 flex items-center gap-3">
        <img src="{{ asset('img/logo.png') }}" 
             alt="Logo" 
             class="w-10 h-10 object-contain bg-white rounded-lg p-1 shadow-sm">
        <span class="text-blue-500 font-bold text-sm leading-tight">
            PEMASARAN PRODUK<br>DAUR ULANG
        </span>
    </div>
    
    <nav class="flex-1 mt-6 px-4 space-y-1 overflow-y-auto custom-scrollbar">
        
        <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mb-2 tracking-widest">Main Menu</p>
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center p-3 rounded-xl transition {{ request()->is('dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
            <i class="fas fa-home w-6 text-sm"></i> 
            <span class="text-sm font-semibold">Dashboard</span>
        </a>

        @if(Auth::user()->level === 'admin')
        
            <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mt-6 mb-2 tracking-widest">Inventory</p>
            
            <a href="{{ route('produk.index') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->is('produk*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-boxes w-6 text-sm"></i> 
                <span class="text-sm">Produk</span>
            </a>

            <a href="{{ route('kategori.index') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->is('kategori*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-tags w-6 text-sm"></i> 
                <span class="text-sm">Kategori</span>
            </a>

            <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mt-6 mb-2 tracking-widest">Transaksi & Keuangan</p>
            
            {{-- BAGIAN TOMBOL PENJUALAN YANG SUDAH DIPERBAIKI --}}
            <a href="{{ route('transaksi.index') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->routeIs('transaksi.index') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-shopping-cart w-6 text-sm"></i> 
                <span class="text-sm">Penjualan</span>
            </a>

            {{-- TOMBOL RIWAYAT TRANSAKSI (TETAP SAMA) --}}
            <a href="{{ route('transaksi.history') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->routeIs('transaksi.history') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-history w-6 text-sm"></i> 
                <span class="text-sm">Riwayat Transaksi</span>
            </a>

<a href="{{ route('laporan.index') }}" 
   class="flex items-center p-3 rounded-xl transition {{ request()->routeIs('laporan*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-chart-pie w-6 text-sm"></i> 
    <span class="text-sm font-semibold">Laporan Keuangan</span>
</a>

            <a href="{{ route('pembelian.index') }}" 
               class="flex items-center p-3 rounded-xl transition hover:bg-slate-800 hover:text-white group">
                <i class="fas fa-file-invoice-dollar w-6 text-sm"></i> 
                <span class="text-sm">Pembelian</span>
                <span class="ml-auto bg-slate-700 text-[9px] px-2 py-0.5 rounded-full text-slate-300">Soon</span>
            </a>

            <a href="{{ route('bank.index') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->is('bank*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-university w-6 text-sm"></i> 
                <span class="text-sm">Bank</span>
            </a>

            <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mt-6 mb-2 tracking-widest">Relasi</p>
            
            <a href="{{ route('supplier.index') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->is('supplier*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-truck w-6 text-sm"></i> 
                <span class="text-sm">Supplier</span>
            </a>

            <a href="{{ route('return.index') }}" 
               class="flex items-center p-3 rounded-xl transition hover:bg-slate-800 hover:text-white">
                <i class="fas fa-undo w-6 text-sm"></i> 
                <span class="text-sm">Return Barang</span>
            </a>

            <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mt-6 mb-2 tracking-widest">Sistem</p>
            
            <a href="{{ route('user.index') }}" 
   class="flex items-center p-3 rounded-xl transition {{ request()->is('user*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-users-cog w-6 text-sm"></i> 
    <span class="text-sm">Kelola User</span>
</a>

            <a href="{{ route('toko.index') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->is('toko*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-cog w-6 text-sm"></i> 
                <span class="text-sm">Pengaturan Toko</span>
            </a>

        @else
            <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mt-6 mb-2 tracking-widest">Transaksi</p>
            <a href="{{ route('transaksi.index') }}" class="flex items-center p-3 rounded-xl transition {{ request()->is('kasir*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-cash-register w-6 text-sm"></i> 
                <span class="font-semibold text-sm">Mesin Kasir</span>
            </a>
            
            <a href="{{ route('transaksi.history') }}" class="flex items-center p-3 rounded-xl transition {{ request()->routeIs('transaksi.history') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-history w-6 text-sm"></i> 
                <span class="text-sm font-semibold">Riwayat Nota</span>
            </a>
        @endif

    </nav>

    <div class="p-4 border-t border-slate-800">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center w-full p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition font-bold text-sm group">
                <i class="fas fa-sign-out-alt w-6 group-hover:text-red-500 transition-colors"></i> 
                <span class="group-hover:text-red-500 transition-colors">KELUAR</span>
            </button>
        </form>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }
</style>