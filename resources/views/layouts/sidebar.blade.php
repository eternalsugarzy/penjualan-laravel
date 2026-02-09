<aside class="w-64 bg-slate-900 min-h-screen sticky top-0 text-slate-300 flex flex-col shadow-2xl">
    <div class="p-6 text-white text-2xl font-black border-b border-slate-800 flex items-center">
        <div class="bg-blue-600 w-8 h-8 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-shopping-cart text-sm"></i>
        </div>
        POS<span class="text-blue-500">PRO</span>
    </div>
    
    <nav class="flex-1 mt-6 px-4 space-y-1 overflow-y-auto">
        
        <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mb-2 tracking-widest">Transaksi</p>
        <a href="{{ route('transaksi.index') }}" class="flex items-center p-3 rounded-xl transition {{ request()->is('kasir*') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
            <i class="fas fa-cash-register w-6 text-sm"></i> 
            <span class="font-semibold text-sm">Mesin Kasir</span>
        </a>

        @if(Auth::user()->level === 'admin')
            <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mt-6 mb-2 tracking-widest">Admin Panel</p>
            
            <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-xl transition {{ request()->is('dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800' }}">
                <i class="fas fa-chart-pie w-6 text-sm"></i> <span class="text-sm">Dashboard</span>
            </a>

            <a href="{{ route('produk.index') }}" class="flex items-center p-3 rounded-xl transition {{ request()->is('produk*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800' }}">
                <i class="fas fa-boxes w-6 text-sm"></i> <span class="text-sm">Data Produk</span>
            </a>

            <a href="{{ route('supplier.index') }}" class="flex items-center p-3 rounded-xl transition {{ request()->is('supplier*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800' }}">
                <i class="fas fa-truck w-6 text-sm"></i> <span class="text-sm">Supplier</span>
            </a>

            <a href="{{ route('toko.index') }}" class="flex items-center p-3 rounded-xl transition {{ request()->is('toko*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800' }}">
                <i class="fas fa-store w-6 text-sm"></i> <span class="text-sm">Pengaturan Toko</span>
            </a>
        @endif

        <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mt-6 mb-2 tracking-widest">Laporan</p>

<a href="{{ route('transaksi.history') }}" 
   class="flex items-center p-3 rounded-xl transition {{ request()->routeIs('transaksi.history') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
    <i class="fas fa-history w-6 text-sm"></i> 
    <span class="text-sm font-semibold">Riwayat Nota</span>
</a>

    </nav>

    <div class="p-4 border-t border-slate-800">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center w-full p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition font-bold text-sm">
                <i class="fas fa-sign-out-alt w-6"></i> <span>KELUAR</span>
            </button>
        </form>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #1e293b;
        border-radius: 10px;
    }
</style>