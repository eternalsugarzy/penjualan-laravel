@extends('layouts.app')

@section('title', 'Riwayat Nota')
@section('header', 'Daftar Transaksi Saya')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-4 text-left">No. Nota</th>
                    <th class="p-4 text-left">Waktu</th>
                    <th class="p-4 text-left">Total Bayar</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($riwayat as $r)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-bold text-blue-600">{{ $r->id_transaksi }}</td>
                    <td class="p-4 text-slate-500">{{ date('d M Y, H:i', strtotime($r->tgl_transaksi)) }}</td>
                    <td class="p-4 font-black text-slate-800">Rp{{ number_format($r->total_harga) }}</td>
                    <td class="p-4 text-center">
                        <a href="{{ route('transaksi.show', $r->id_transaksi) }}" target="_blank" 
                           class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-900 hover:text-white transition">
                            <i class="fas fa-print mr-2"></i> Cetak Ulang
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-10 text-center text-slate-400 italic">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection