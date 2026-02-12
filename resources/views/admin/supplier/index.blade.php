@extends('layouts.app')

@section('title', 'Supplier')
@section('header', 'Data Rekanan Supplier')

@section('content')
{{-- Load SweetAlert untuk notifikasi dan konfirmasi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="space-y-6">
    {{-- ========================================== --}}
    {{-- 1. KOP SURAT (MUNCUL SAAT PRINT)           --}}
    {{-- ========================================== --}}
    <div id="kop-surat" class="hidden font-serif mb-6">
        <div class="flex items-center border-b-4 border-double border-black pb-4">
            {{-- LOGO PEMKO (KIRI) --}}
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
                    Email: <span class="underline text-blue-900 leading-tight">dlh.banjarmasin@gmail.com</span>
                </p>
            </div>
        </div>
        <div class="text-center mt-4">
            <h2 class="text-lg font-bold uppercase underline underline-offset-4 font-sans">LAPORAN DAFTAR REKANAN SUPPLIER</h2>
            <p class="text-sm mt-1 font-bold font-sans">Per Tanggal: {{ date('d F Y') }}</p>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. TABEL DATA (WEB & PRINT)                --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden print:border-0 print:shadow-none print:rounded-none">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center no-print">
            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider">List Supplier</h3>
            <div class="flex gap-2">
                {{-- Tombol Cetak --}}
                <button onclick="window.print()" class="bg-slate-100 text-slate-700 px-5 py-2 rounded-xl font-bold hover:bg-slate-200 transition border border-slate-200">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
                {{-- Tombol Tambah --}}
                <button onclick="toggleModal('modalSupplier')" class="bg-slate-900 text-white px-5 py-2 rounded-xl font-bold shadow-lg hover:bg-slate-800 transition">
                    <i class="fas fa-truck mr-2"></i> Tambah Supplier
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto print:overflow-visible">
            <table class="w-full text-sm print:text-black">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] print:bg-slate-100 print:text-black">
                    <tr>
                        <th class="p-4 text-left print:border print:border-black print:p-2 print:text-center w-12">No</th>
                        <th class="p-4 text-left print:border print:border-black print:p-2">Nama Perusahaan</th>
                        <th class="p-4 text-left print:border print:border-black print:p-2">Kontak (Telp)</th>
                        <th class="p-4 text-left print:border print:border-black print:p-2">Alamat Lengkap</th>
                        <th class="p-4 text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 print:divide-none">
                    @forelse($suppliers as $index => $s)
                    <tr class="hover:bg-slate-50 transition print:hover:bg-transparent">
                        <td class="p-4 text-slate-500 print:border print:border-black print:p-2 print:text-center">{{ $index + 1 }}</td>
                        <td class="p-4 print:border print:border-black print:p-2 font-bold text-slate-800 print:text-black uppercase tracking-tight">{{ $s->nama_supplier }}</td>
                        <td class="p-4 print:border print:border-black print:p-2 text-slate-600 print:text-black font-mono tracking-tighter">{{ $s->telp }}</td>
                        <td class="p-4 text-slate-500 print:text-black print:border print:border-black print:p-2 whitespace-normal leading-tight">{{ $s->alamat }}</td>
                        <td class="p-4 text-center no-print">
                            <div class="flex justify-center gap-2">
                                <button onclick="editSupplier(this)" 
                                    data-id="{{ $s->id_supplier }}"
                                    data-nama="{{ $s->nama_supplier }}"
                                    data-telp="{{ $s->telp }}"
                                    data-alamat="{{ $s->alamat }}"
                                    class="text-amber-500 hover:text-amber-700 transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('supplier.destroy', $s->id_supplier) }}" method="POST" class="form-delete">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="text-red-400 hover:text-red-600 transition" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-slate-400 italic print:border print:border-black">Belum ada data supplier.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 3. TANDA TANGAN (HANYA MUNCUL SAAT PRINT)  --}}
    {{-- ========================================== --}}
   
</div>

{{-- MODAL TAMBAH & EDIT --}}
<div id="modalSupplier" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50 no-print">
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
            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition uppercase tracking-widest">
                SIMPAN DATA SUPPLIER
            </button>
        </form>
    </div>
</div>

<div id="modalEditSupplier" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50 no-print">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden animate-fade-in-down">
        <div class="p-6 border-b flex justify-between items-center bg-amber-50">
            <h3 class="font-black text-slate-800 uppercase tracking-tight">Edit Supplier</h3>
            <button onclick="toggleModal('modalEditSupplier')" class="text-slate-400 hover:text-red-500 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditSupplier" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
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
            <button type="submit" class="w-full bg-amber-500 text-white py-4 rounded-2xl font-black shadow-lg shadow-amber-200 hover:bg-amber-600 transition uppercase tracking-widest">
                UPDATE SUPPLIER
            </button>
        </form>
    </div>
</div>

{{-- STYLE PRINT FORMAL --}}
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
        
        /* Maksa tabel jadi format kotak-kotak resmi */
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
            -webkit-print-color-adjust: exact;
        }

        .font-serif { font-family: 'Times New Roman', Times, serif !important; }
        .font-sans { font-family: Arial, Helvetica, sans-serif !important; }
    }
</style>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    function editSupplier(btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const telp = btn.getAttribute('data-telp');
        const alamat = btn.getAttribute('data-alamat');

        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_telp').value = telp;
        document.getElementById('edit_alamat').value = alamat;

        const form = document.getElementById('formEditSupplier');
        form.action = "{{ url('supplier') }}/" + id;

        toggleModal('modalEditSupplier');
    }

    function confirmDelete(btn) {
        Swal.fire({
            title: 'Hapus Supplier?',
            text: "Data rekanan ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => { 
            if (result.isConfirmed) {
                btn.closest('.form-delete').submit();
            } 
        });
    }

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif
</script>
@endsection