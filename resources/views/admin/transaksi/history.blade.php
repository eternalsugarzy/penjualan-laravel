@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('header', 'Riwayat Penjualan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Data Transaksi</h3>
        </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-4">No. Nota</th>
                    <th class="p-4">Waktu</th>
                    <th class="p-4 w-1/3">Detail Pesanan (Produk x Qty)</th> <th class="p-4">Total Bayar</th>
                    <th class="p-4 text-center">Kasir</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transaksi as $trx)
                <tr class="hover:bg-slate-50 transition align-top">
                    <td class="p-4 font-mono font-bold text-blue-600">
                        {{ $trx->id_transaksi }}
                    </td>
                    <td class="p-4 text-slate-500">
                        {{ date('d M Y, H:i', strtotime($trx->tgl_transaksi)) }}
                    </td>
                    
                    <td class="p-4">
                        <ul class="space-y-1">
                            @foreach($trx->details as $detail)
                                <li class="text-xs text-slate-700 flex justify-between border-b border-dashed border-slate-200 pb-1 last:border-0">
                                    <span>{{ $detail->nama_produk }}</span>
                                    <span class="font-bold text-slate-500">x{{ $detail->qty }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </td>

                    <td class="p-4 font-black text-slate-800">
                        Rp{{ number_format($trx->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-center">
                        <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-bold uppercase">
                            {{ $trx->user->name ?? 'Unknown' }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <a href="{{ route('transaksi.cetak', $trx->id_transaksi) }}" target="_blank" 
                           class="bg-blue-50 text-blue-600 px-3 py-2 rounded-lg font-bold text-xs hover:bg-blue-100 transition inline-flex items-center gap-2">
                            <i class="fas fa-print"></i> Cetak Nota
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400">
                        <div class="mb-2"><i class="fas fa-receipt text-4xl opacity-50"></i></div>
                        Belum ada riwayat transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection