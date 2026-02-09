@extends('layouts.app')

@section('title', 'Kelola User')
@section('header', 'Manajemen Pengguna Sistem')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Kelola User</h1>
        <button onclick="toggleModal('modalTambah')" 
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah User
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold">
                <tr>
                    <th class="p-4 border-b">Nama</th>
                    <th class="p-4 border-b">Username / Email</th>
                    <th class="p-4 border-b">Level</th>
                    <th class="p-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @foreach($users as $u)
                <tr class="hover:bg-slate-50 border-b last:border-b-0">
                    <td class="p-4 font-semibold">{{ $u->nama }}</td>
                    <td class="p-4">
                        <div class="font-bold">{{ $u->username }}</div>
                        <div class="text-slate-400 text-xs">{{ $u->email }}</div>
                    </td>
                    <td class="p-4">
                        @if($u->level == 'admin')
                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-bold">Admin</span>
                        @elseif($u->level == 'petugas')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold">Petugas</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold">Pelanggan</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            {{-- Tombol Edit --}}
                            <button onclick="editUser(this)" 
                                data-id="{{ $u->id }}"
                                data-nama="{{ $u->nama }}"
                                data-username="{{ $u->username }}"
                                data-email="{{ $u->email }}"
                                data-level="{{ $u->level }}"
                                class="bg-yellow-100 text-yellow-600 w-8 h-8 rounded flex items-center justify-center hover:bg-yellow-200">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            {{-- Form Hapus --}}
                            <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="form-delete">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="bg-red-100 text-red-600 w-8 h-8 rounded flex items-center justify-center hover:bg-red-200">
                                    <i class="fas fa-trash"></i>
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

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-lg">Tambah User Baru</h3>
            <button onclick="toggleModal('modalTambah')" class="text-slate-400 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('user.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Username</label>
                <input type="text" name="username" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Level Akses</label>
                <select name="level" class="w-full border rounded-lg px-3 py-2 outline-none bg-white">
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas Kasir</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">Simpan User</button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-lg text-yellow-600 italic">Edit User</h3>
            <button onclick="toggleModal('modalEdit')" class="text-slate-400 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditUser" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" id="edit_nama" name="nama" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Username</label>
                <input type="text" id="edit_username" name="username" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Email</label>
                <input type="email" id="edit_email" name="email" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1 font-mono">Password <span class="text-[10px] text-slate-400 font-normal italic">(Kosongkan jika tidak diganti)</span></label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1 font-mono tracking-tighter">Level Akses</label>
                <select id="edit_level" name="level" class="w-full border rounded-lg px-3 py-2 outline-none bg-white">
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas Kasir</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-yellow-500 text-white font-black py-3 rounded-lg hover:bg-yellow-600 transition shadow-lg shadow-yellow-100">Update User</button>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    // Fungsi Isi Data Modal Edit
    function editUser(btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const username = btn.getAttribute('data-username');
        const email = btn.getAttribute('data-email');
        const level = btn.getAttribute('data-level');

        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_level').value = level;

        const form = document.getElementById('formEditUser');
        form.action = "{{ url('user') }}/" + id;

        toggleModal('modalEdit');
    }

    // Fungsi Konfirmasi Hapus SweetAlert
    function confirmDelete(btn) {
        Swal.fire({
            title: 'Hapus User?',
            text: "User ini tidak akan bisa login lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('.form-delete').submit();
            }
        });
    }

    // Notifikasi Sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection