@extends('layouts.app')

@section('title', 'Kelola User')
@section('header', 'Manajemen Pengguna Sistem')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="space-y-6">

    {{-- ========================================== --}}
    {{-- 1. KOP SURAT (HANYA MUNCUL SAAT PRINT)     --}}
    {{-- ========================================== --}}
    <div id="kop-surat" class="hidden font-serif mb-6">
        <div class="flex items-center border-b-4 border-double border-black pb-4">
            {{-- LOGO (KIRI) --}}
            <div class="w-1/5 flex justify-center">
                <img src="{{ asset('img/logopemko.jpeg') }}" 
                     alt="Logo" class="w-24 h-auto object-contain"
                     onerror="this.src='https://placehold.co/100x100?text=LOGO'">
            </div>
            
            {{-- TEKS KOP (TENGAH) --}}
            <div class="w-4/5 text-center pr-10">
                <h3 class="text-xl font-bold text-black uppercase leading-tight">PEMERINTAH KOTA BANJARMASIN</h3>
                <h2 class="text-3xl font-black text-black uppercase tracking-wide leading-tight">DINAS LINGKUNGAN HIDUP</h2>
                <p class="text-sm text-black mt-1 leading-snug">
                    Jalan R.E. Martadinata No. 1 Gedung Blok D Lt. 2 Banjarmasin 70111<br>
                    Telepon: (0511) 33633792, 4368145, 3363811, Faksimile. (0511) 3363792, 3363811<br>
                    Email: <span class="underline text-blue-900">dlh.banjarmasin@gmail.com</span>
                </p>
            </div>
        </div>
        <div class="text-center mt-4">
            <h2 class="text-lg font-bold uppercase underline underline-offset-4 font-sans">LAPORAN DATA PENGGUNA SISTEM</h2>
            <p class="text-sm mt-1 font-bold font-sans">Per Tanggal: {{ date('d F Y') }}</p>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. TAMPILAN WEB (DAFTAR USER)              --}}
    {{-- ========================================== --}}
    <div class="no-print p-1">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Kelola User</h1>
                <p class="text-slate-500 text-sm">Daftar pengguna yang memiliki akses ke sistem</p>
            </div>
            <div class="flex gap-3">
                <button onclick="window.print()" class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg font-bold hover:bg-slate-200 transition border border-slate-200">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
                <button onclick="toggleModal('modalTambah')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-lg shadow-blue-500/30">
                    <i class="fas fa-plus"></i> Tambah User
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold">
                    <tr>
                        <th class="p-4 border-b">No</th>
                        <th class="p-4 border-b">Nama Lengkap</th>
                        <th class="p-4 border-b">Username / Email</th>
                        <th class="p-4 border-b">Level</th>
                        <th class="p-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700">
                    @foreach($users as $index => $u)
                    <tr class="hover:bg-slate-50 border-b last:border-b-0">
                        <td class="p-4">{{ $index + 1 }}</td>
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
                                <button onclick="editUser(this)" 
                                    data-id="{{ $u->id }}"
                                    data-nama="{{ $u->nama }}"
                                    data-username="{{ $u->username }}"
                                    data-email="{{ $u->email }}"
                                    data-level="{{ $u->level }}"
                                    class="bg-yellow-100 text-yellow-600 w-8 h-8 rounded flex items-center justify-center hover:bg-yellow-200 transition">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="form-delete">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="bg-red-100 text-red-600 w-8 h-8 rounded flex items-center justify-center hover:bg-red-200 transition">
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

    {{-- ========================================== --}}
    {{-- 3. TABEL KHUSUS CETAK (HIDDEN DI WEB)      --}}
    {{-- ========================================== --}}
    <div class="hidden print:block">
        <table class="w-full text-left border-collapse border border-black">
            <thead class="bg-slate-100 text-black uppercase text-xs font-bold">
                <tr>
                    <th class="p-2 border border-black text-center w-10">No</th>
                    <th class="p-2 border border-black">Nama Lengkap</th>
                    <th class="p-2 border border-black">Username</th>
                    <th class="p-2 border border-black">Email</th>
                    <th class="p-2 border border-black text-center">Level</th>
                </tr>
            </thead>
            <tbody class="text-sm text-black">
                @foreach($users as $index => $u)
                <tr>
                    <td class="p-2 border border-black text-center">{{ $index + 1 }}</td>
                    <td class="p-2 border border-black">{{ $u->nama }}</td>
                    <td class="p-2 border border-black">{{ $u->username }}</td>
                    <td class="p-2 border border-black">{{ $u->email }}</td>
                    <td class="p-2 border border-black text-center uppercase">{{ $u->level }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ========================================== --}}
    {{-- 4. TANDA TANGAN (HANYA MUNCUL SAAT PRINT)  --}}
    {{-- ========================================== --}}
    <div class="hidden print-footer mt-10 grid grid-cols-2 font-sans">
        <div></div> 
        <div class="text-center">
            <p>Banjarmasin, {{ date('d F Y') }}</p>
            <p class="mb-20">Mengetahui,</p>
            <p class="font-bold underline">{{ Auth::user()->name }}</p>
            <p>Admin / Petugas</p>
        </div>
    </div>

</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 no-print">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden animate-fade-in-down">
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
<div id="modalEdit" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 no-print">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden animate-fade-in-down">
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

<style>
    @media print {
        @page { size: A4; margin: 1.5cm; }
        body { background: white !important; -webkit-print-color-adjust: exact; font-family: 'Times New Roman', serif; }
        
        .no-print, header, aside, nav, button, form, .modal, .sidebar { 
            display: none !important; 
        }

        #kop-surat, .print-footer { 
            display: block !important; 
        }
        .print-footer { display: grid !important; }
        
        .space-y-6 { position: static; width: 100%; margin: 0; padding: 0; }
        
        /* Tabel Print */
        table { 
            width: 100% !important; 
            border-collapse: collapse !important; 
            margin-top: 20px;
        }
        th, td { 
            border: 1px solid black !important;
            padding: 8px !important; 
            color: black !important;
        }
        thead th { 
            background-color: #f2f2f2 !important; 
            font-weight: bold !important;
            text-align: center !important;
        }

        .font-serif { font-family: 'Times New Roman', Times, serif !important; }
        .font-sans { font-family: Arial, Helvetica, sans-serif !important; }
    }
</style>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

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