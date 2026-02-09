@extends('layouts.app')

@section('title', 'Data Produk')
@section('header', 'Manajemen Stok Produk')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-700">Daftar Barang</h3>
        <button onclick="toggleModal('modalProduk')" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Produk Baru
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-4 text-left">Info Produk</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Harga Jual</th>
                    <th class="p-4 text-left">Stok</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($produk as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/produk/'.$p->gambar) }}" class="w-10 h-10 rounded-lg object-cover border" onerror="this.src='https://ui-avatars.com/api/?name={{ $p->nama_produk }}&background=random'">
                            <div>
                                <p class="font-bold text-slate-800">{{ $p->nama_produk }}</p>
                                <p class="text-[10px] text-slate-400 font-mono uppercase">{{ $p->id_produk }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-slate-500">{{ $p->nama_kategori ?? 'N/A' }}</td>
                    <td class="p-4 font-bold text-slate-800">Rp{{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $p->stok < 10 ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                            {{ $p->stok }} UNIT
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <form action="{{ route('produk.destroy', $p->id_produk) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete(this)" class="text-red-400 hover:text-red-600 transition">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-slate-400 italic">Belum ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modalProduk" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center">
            <h3 class="font-black text-slate-800 uppercase tracking-tight">Tambah Produk Baru</h3>
            <button onclick="toggleModal('modalProduk')" class="text-slate-400 hover:text-red-500 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="p-6 grid grid-cols-2 gap-4">
            @csrf
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ID Produk / SKU</label>
                <input type="text" name="id_produk" class="w-full border-slate-200 rounded-xl p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none border transition" placeholder="Contoh: BRG001" required>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Nama Barang</label>
                <input type="text" name="nama_produk" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none border" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Kategori</label>
                <select name="id_kategori" class="w-full border-slate-200 rounded-xl p-3 outline-none border bg-white">
                    @foreach($kategori as $cat)
                    <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Stok Awal</label>
                <input type="number" name="stok" class="w-full border-slate-200 rounded-xl p-3 outline-none border" value="0" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Harga Beli</label>
                <input type="number" name="harga_beli" class="w-full border-slate-200 rounded-xl p-3 outline-none border" placeholder="0">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Harga Jual</label>
                <input type="number" name="harga_jual" class="w-full border-slate-200 rounded-xl p-3 outline-none border" placeholder="0" required>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Foto Produk</label>
                <input type="file" name="gambar" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div class="col-span-2 pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition uppercase tracking-widest">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }

    function confirmDelete(btn) {
        Swal.fire({
            title: 'Yakin dihapus?',
            text: "Data produk akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('form').submit();
            }
        });
    }
</script>
@endsection