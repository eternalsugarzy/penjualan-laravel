@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Kelola User</h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
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
                    <td class="p-4 flex justify-center gap-2">
                        <button class="bg-yellow-100 text-yellow-600 w-8 h-8 rounded flex items-center justify-center hover:bg-yellow-200">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                        <form action="{{ route('user.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-100 text-red-600 w-8 h-8 rounded flex items-center justify-center hover:bg-red-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-lg">Tambah User Baru</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('user.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Username</label>
                <input type="text" name="username" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-1">Level Akses</label>
                <select name="level" class="w-full border rounded-lg px-3 py-2">
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas Kasir</option>
                    <option value="pelanggan">Pelanggan</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700">Simpan User</button>
        </form>
    </div>
</div>
@endsection