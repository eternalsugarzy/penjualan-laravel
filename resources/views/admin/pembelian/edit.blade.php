@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Edit Pembelian Stok</h1>
        <a href="{{ route('pembelian.index') }}" class="text-slate-500 hover:text-blue-600">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- 1. MENAMPILKAN ERROR VALIDASI (WAJIB ADA UNTUK DEBUGGING) --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 2. MENAMPILKAN NOTIFIKASI ERROR DARI CONTROLLER --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('pembelian.update', $pembelian->id_pembelian ?? $pembelian->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2">Supplier</label>
                <select name="id_supplier" class="w-full border p-2 rounded-lg bg-slate-50">
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id_supplier }}" {{ (old('id_supplier', $pembelian->id_supplier) == $s->id_supplier) ? 'selected' : '' }}>
                            {{ $s->nama_supplier }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2">Tanggal Beli</label>
                <input type="date" name="tgl_beli" value="{{ old('tgl_beli', $pembelian->tgl_beli) }}" class="w-full border p-2 rounded-lg bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2">No Faktur</label>
                <input type="text" name="no_faktur" value="{{ old('no_faktur', $pembelian->no_faktur) }}" class="w-full border p-2 rounded-lg bg-slate-50">
            </div>
        </div>

        <hr class="mb-6">

        <h3 class="font-bold text-slate-700 mb-4">Item Barang</h3>
        <div id="item-list">
            {{-- Loop Data Lama --}}
            @foreach($pembelian->details as $index => $detail)
            <div class="grid grid-cols-12 gap-2 mb-2 item-row">
                <div class="col-span-5">
                    <select name="id_produk[]" class="w-full border p-2 rounded" required>
                        @foreach($produks as $p)
                            <option value="{{ $p->id_produk }}" {{ $detail->produk_id == $p->id_produk ? 'selected' : '' }}>
                                {{ $p->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-3">
                    <input type="number" name="harga_beli[]" value="{{ $detail->harga_beli }}" class="w-full border p-2 rounded" placeholder="Harga Beli" required>
                </div>
                <div class="col-span-2">
                    <input type="number" name="qty[]" value="{{ $detail->qty }}" class="w-full border p-2 rounded" placeholder="Qty" required min="1">
                </div>
                <div class="col-span-2 text-center">
                    @if($index == 0)
                        <button type="button" onclick="tambahBaris()" class="bg-blue-100 text-blue-600 p-2 rounded w-full hover:bg-blue-200"><i class="fas fa-plus"></i></button>
                    @else
                        <button type="button" onclick="hapusBaris(this)" class="bg-red-100 text-red-600 p-2 rounded w-full hover:bg-red-200"><i class="fas fa-trash"></i></button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 pt-6 border-t">
            <button type="submit" class="bg-amber-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-amber-600 w-full shadow-lg transition transform active:scale-95">
                UPDATE PERUBAHAN & SESUAIKAN STOK
            </button>
        </div>
    </form>
</div>

<script>
    function tambahBaris() {
        let html = `
        <div class="grid grid-cols-12 gap-2 mb-2 item-row">
            <div class="col-span-5">
                <select name="id_produk[]" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $p)
                        <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3">
                <input type="number" name="harga_beli[]" class="w-full border p-2 rounded" placeholder="Harga Beli" required>
            </div>
            <div class="col-span-2">
                <input type="number" name="qty[]" class="w-full border p-2 rounded" placeholder="Qty" required min="1">
            </div>
            <div class="col-span-2 text-center">
                <button type="button" onclick="hapusBaris(this)" class="bg-red-100 text-red-600 p-2 rounded w-full hover:bg-red-200"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
        document.getElementById('item-list').insertAdjacentHTML('beforeend', html);
    }

    function hapusBaris(btn) {
        // Cek agar baris terakhir tidak bisa dihapus semua (minimal sisa 1)
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.closest('.item-row').remove();
        } else {
            alert("Minimal harus ada satu barang!");
        }
    }
</script>
@endsection