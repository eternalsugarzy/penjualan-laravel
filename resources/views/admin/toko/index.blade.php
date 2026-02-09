@extends('layouts.app')

@section('title', 'Pengaturan Toko')
@section('header', 'Identitas Toko')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b bg-slate-50">
            <h3 class="font-black text-slate-800 uppercase tracking-tighter">Setting Profil Toko</h3>
        </div>
        <form action="{{ route('toko.update') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Nama Toko / Bisnis</label>
                <input type="text" name="nama_toko" value="{{ $toko->nama_toko ?? '' }}" 
                    class="w-full border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none border font-bold text-slate-700">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Deskripsi / Slogan</label>
                <textarea name="deskripsi" rows="4" 
                    class="w-full border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none border text-slate-600">{{ $toko->deskripsi ?? '' }}</textarea>
            </div>
            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black hover:bg-blue-600 transition shadow-xl">
                UPDATE INFORMASI TOKO
            </button>
        </form>
    </div>
</div>
@endsection