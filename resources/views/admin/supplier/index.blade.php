@extends('layouts.app')

@section('title', 'Supplier')
@section('header', 'Data Rekanan Supplier')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider">List Supplier</h3>
        <button onclick="toggleModal('modalSupplier')" class="bg-slate-900 text-white px-5 py-2 rounded-xl font-bold shadow-lg hover:bg-slate-800 transition">
            <i class="fas fa-truck mr-2"></i> Tambah Supplier
        </button>
    </div>
    
    {{-- Notifikasi Sukses/Gagal --}}
    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 font-bold border-b border-emerald-200">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-4 text-left">Nama Perusahaan</th>
                    <th class="p-4 text-left">Kontak</th>
                    <th class="p-4 text-left">Alamat</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($suppliers as $s)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4">
                        <p class="font-bold text-slate-800">{{ $s->nama_supplier }}</p>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center text-slate-600">
                            <i class="fab fa-whatsapp text-emerald-500 mr-2"></i>
                            {{ $s->telp }}
                        </div>
                    </td>
                    <td class="p-4 text-slate-500 max-w-xs truncate">{{ $s->alamat }}</td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            {{-- TOMBOL EDIT --}}
                            <button onclick="editSupplier(this)" 
                                data-id="{{ $s->id_supplier }}"
                                data-nama="{{ $s->nama_supplier }}"
                                data-telp="{{ $s->telp }}"
                                data-alamat="{{ $s->alamat }}"
                                class="text-amber-500 hover:text-amber-700 transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- TOMBOL HAPUS --}}
                            <form action="{{ route('supplier.destroy', $s->id_supplier) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH SUPPLIER --}}
<div id="modalSupplier" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden animate-fade-in-down">
        <div class="p-6 border-b flex justify-between items-center bg-slate-50">
            <h3 class="font-black text-slate-800 uppercase tracking-tight">Tambah Supplier</h3>
            <button onclick="toggleModal('modalSupplier')" class="text-slate-400 hover:text-red-500 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('supplier.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Nama Supplier</label>
                <input type="text" name="nama_supplier" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none border" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Nomor Telepon/WA</label>
                <input type="text" name="telp" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none border" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none border" required></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                SIMPAN DATA SUPPLIER
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT SUPPLIER (BARU) --}}
<div id="modalEditSupplier" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden animate-fade-in-down">
        <div class="p-6 border-b flex justify-between items-center bg-amber-50">
            <h3 class="font-black text-slate-800 uppercase tracking-tight">Edit Supplier</h3>
            <button onclick="toggleModal('modalEditSupplier')" class="text-slate-400 hover:text-red-500 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditSupplier" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT') {{-- Wajib untuk Update --}}
            
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Nama Supplier</label>
                <input type="text" id="edit_nama" name="nama_supplier" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 outline-none border" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Nomor Telepon/WA</label>
                <input type="text" id="edit_telp" name="telp" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 outline-none border" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Alamat Lengkap</label>
                <textarea id="edit_alamat" name="alamat" rows="3" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 outline-none border" required></textarea>
            </div>
            <button type="submit" class="w-full bg-amber-500 text-white py-4 rounded-2xl font-black shadow-lg shadow-amber-200 hover:bg-amber-600 transition">
                UPDATE SUPPLIER
            </button>
        </form>
    </div>
</div>

<script>
    // Fungsi Buka Tutup Modal
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    // Fungsi Isi Data ke Modal Edit
    function editSupplier(btn) {
        // 1. Ambil data dari tombol
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const telp = btn.getAttribute('data-telp');
        const alamat = btn.getAttribute('data-alamat');

        // 2. Isi Inputan Form
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_telp').value = telp;
        document.getElementById('edit_alamat').value = alamat;

        // 3. Update Action URL Form
        // Asumsi Route: Route::resource('supplier', SupplierController::class);
        // Maka URL update: domain.com/supplier/{id}
        const form = document.getElementById('formEditSupplier');
        form.action = "{{ url('supplier') }}/" + id;

        // 4. Buka Modal
        toggleModal('modalEditSupplier');
    }
</script>
@endsection