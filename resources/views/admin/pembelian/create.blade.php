@extends('layouts.app')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    
    <a href="{{ route('pembelian.index') }}" class="inline-flex items-center text-slate-500 hover:text-blue-600 mb-6 transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
    </a>

    <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">Input Pembelian Stok Baru</h2>
        </div>

        <form action="{{ route('pembelian.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Pilih Supplier</label>
                    <select name="supplier_id" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id_supplier }}">{{ $sup->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Beli</label>
                    <input type="date" name="tgl_beli" value="{{ date('Y-m-d') }}" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">No. Faktur (Opsional)</label>
                    <input type="text" name="no_faktur" placeholder="Contoh: INV-001" class="w-full border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Daftar Barang yang Dibeli</label>
                <div class="border rounded-xl overflow-hidden">
                    <table class="w-full text-left" id="tabel-produk">
                        <thead class="bg-slate-100 text-slate-600 text-xs uppercase font-bold">
                            <tr>
                                <th class="p-3">Nama Produk</th>
                                <th class="p-3 w-40">Harga Beli (Satuan)</th>
                                <th class="p-3 w-32">Qty (Jumlah)</th>
                                <th class="p-3 w-16 text-center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="bg-white">
                                <td class="p-2">
                                    <select name="produk_id[]" class="w-full border-slate-300 rounded focus:ring-blue-500 text-sm" required>
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach($produks as $p)
                                            <option value="{{ $p->id_produk }}">{{ $p->nama_produk }} (Stok Saat Ini: {{ $p->stok }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-2">
                                    <input type="number" name="harga_beli[]" class="w-full border-slate-300 rounded focus:ring-blue-500 text-sm" placeholder="0" min="0" required>
                                </td>
                                <td class="p-2">
                                    <input type="number" name="qty[]" class="w-full border-slate-300 rounded focus:ring-blue-500 text-sm" placeholder="1" min="1" required>
                                </td>
                                <td class="p-2 text-center">
                                    <button type="button" class="text-red-400 hover:text-red-600 transition" disabled>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <button type="button" onclick="tambahBaris()" class="mt-3 text-sm bg-blue-50 text-blue-600 px-4 py-2 rounded-lg font-bold hover:bg-blue-100 transition flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i> Tambah Baris Barang
                </button>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('pembelian.index') }}" class="px-6 py-2.5 rounded-lg font-bold text-slate-600 hover:bg-slate-100 transition">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                    SIMPAN STOK MASUK
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function tambahBaris() {
        var table = document.getElementById("tabel-produk").getElementsByTagName('tbody')[0];
        var firstRow = table.rows[0];
        var newRow = firstRow.cloneNode(true); // Clone baris pertama

        // Reset nilai input di baris baru
        var inputs = newRow.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) { inputs[i].value = ''; }
        
        var selects = newRow.getElementsByTagName('select');
        for (var i = 0; i < selects.length; i++) { selects[i].value = ''; }

        // Aktifkan tombol hapus di baris baru
        var btn = newRow.getElementsByTagName('button')[0];
        btn.disabled = false;
        btn.setAttribute('onclick', 'hapusBaris(this)');

        table.appendChild(newRow); // Masukkan ke tabel
    }

    function hapusBaris(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
@endsection