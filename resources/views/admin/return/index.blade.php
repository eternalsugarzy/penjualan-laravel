@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Return Barang</h1>
        <a href="{{ route('return.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
            <i class="fas fa-undo mr-2"></i> Retur Baru
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold">
                <tr>
                    <th class="p-4 border-b">Tanggal</th>
                    <th class="p-4 border-b">Supplier</th>
                    <th class="p-4 border-b">Nama Barang</th>
                    <th class="p-4 border-b">Qty</th>
                    <th class="p-4 border-b">Keterangan</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse($returns as $r)
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-4">{{ $r->created_at ? $r->created_at->format('d M Y') : '-' }}</td>
                    <td class="p-4 font-bold">{{ $r->supplier->nama_supplier ?? '-' }}</td>
                    <td class="p-4">{{ $r->produk->nama_produk ?? '-' }}</td>
                    <td class="p-4 font-bold text-red-600">-{{ $r->qty }}</td>
                    <td class="p-4 text-slate-500 italic">{{ $r->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-slate-400">Belum ada data retur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection