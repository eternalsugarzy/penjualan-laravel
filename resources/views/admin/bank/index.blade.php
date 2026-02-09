@extends('layouts.app')

@section('title', 'Metode Pembayaran')
@section('header', 'Rekening Bank')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="font-bold text-slate-700 uppercase text-sm">Daftar Rekening</h3>
        <button onclick="toggleModal('modalBank')" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition text-sm">
            <i class="fas fa-plus mr-2"></i> Tambah Bank
        </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        @foreach($bank as $b)
        <div class="bg-slate-50 border border-slate-200 p-6 rounded-3xl relative group overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-blue-600 uppercase mb-1">{{ $b->nama_bank }}</p>
                <h4 class="text-xl font-black text-slate-800 tracking-tighter">{{ $b->no_rekening }}</h4>
                <p class="text-sm text-slate-500 mt-1 font-medium">a.n {{ $b->atas_nama }}</p>
            </div>
            <form action="{{ route('bank.destroy', $b->id_bank) }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
            </form>
            <i class="fas fa-university absolute -right-4 -bottom-4 text-6xl text-slate-200 opacity-50"></i>
        </div>
        @endforeach
    </div>
</div>

<div id="modalBank" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl p-8">
        <h3 class="font-black text-slate-800 uppercase mb-6">Tambah Rekening</h3>
        <form action="{{ route('bank.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="nama_bank" placeholder="Nama Bank (Contoh: BCA / BRI)" class="w-full border rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="text" name="no_rekening" placeholder="Nomor Rekening" class="w-full border rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="text" name="atas_nama" placeholder="Atas Nama (Pemilik)" class="w-full border rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500" required>
            <div class="flex space-x-2 pt-4">
                <button type="button" onclick="toggleModal('modalBank')" class="flex-1 bg-slate-100 text-slate-600 py-3 rounded-xl font-bold">Batal</button>
                <button type="submit" class="flex-2 bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-100">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }
</script>
@endsection