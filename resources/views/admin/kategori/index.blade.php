@extends('layouts.app')

@section('title', 'Kategori')
@section('header', 'Master Kategori Produk')

@section('content')
{{-- Load SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="space-y-6">
    {{-- ========================================== --}}
    {{-- 1. KOP SURAT (MUNCUL SAAT PRINT)           --}}
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
            <h2 class="text-lg font-bold uppercase underline underline-offset-4 font-sans">LAPORAN DAFTAR KATEGORI PRODUK</h2>
            <p class="text-sm mt-1 font-bold font-sans">Per Tanggal: {{ date('d F Y') }}</p>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. TABEL DATA (WEB & PRINT)                --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden print:border-0 print:shadow-none print:rounded-none">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center no-print">
            <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Daftar Kategori</h3>
            <div class="flex gap-2">
                <button onclick="window.print()" class="bg-slate-100 text-slate-700 px-5 py-2 rounded-xl font-bold hover:bg-slate-200 transition border border-slate-200">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
                <button onclick="addKategori()" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> Kategori Baru
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto print:overflow-visible">
            <table class="w-full text-sm print:text-black">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] print:bg-slate-100 print:text-black">
                    <tr>
                        <th class="p-4 text-left w-20 print:border print:border-black print:p-2 print:text-center">No</th>
                        <th class="p-4 text-left print:border print:border-black print:p-2">Nama Kategori Produk</th>
                        <th class="p-4 text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 print:divide-none">
                    @forelse($kategori as $index => $k)
                    <tr class="hover:bg-slate-50 transition print:hover:bg-transparent">
                        <td class="p-4 text-slate-500 print:border print:border-black print:p-2 print:text-center">{{ $index + 1 }}</td>
                        <td class="p-4 font-bold text-slate-800 print:text-black print:border print:border-black print:p-2 uppercase font-mono">{{ $k->nama_kategori }}</td>
                        <td class="p-4 text-center flex justify-center space-x-2 no-print">
                            <button onclick="editKategori('{{ $k->id_kategori }}', '{{ $k->nama_kategori }}')" class="text-amber-500 hover:bg-amber-50 w-8 h-8 rounded-lg transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="text-red-400 hover:bg-red-50 w-8 h-8 rounded-lg transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-10 text-center text-slate-400 italic print:border print:border-black">Belum ada data kategori.</td>
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
    function addKategori() {
        Swal.fire({
            title: 'Tambah Kategori',
            input: 'text',
            inputPlaceholder: 'Masukkan nama kategori...',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            confirmButtonColor: '#2563eb',
            preConfirm: (name) => {
                if (!name) return Swal.showValidationMessage('Nama wajib diisi!')
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('kategori.store') }}";
                form.innerHTML = `@csrf <input name="nama_kategori" value="${name}">`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function editKategori(id, currentName) {
        Swal.fire({
            title: 'Edit Kategori',
            input: 'text',
            inputValue: currentName,
            showCancelButton: true,
            confirmButtonText: 'Update',
            confirmButtonColor: '#f59e0b',
            preConfirm: (name) => {
                if (!name) return Swal.showValidationMessage('Nama tidak boleh kosong!')
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = `/kategori/${id}`;
                form.innerHTML = `@csrf @method('PUT') <input name="nama_kategori" value="${name}">`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function confirmDelete(btn) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Pastikan tidak ada produk yang terikat dengan kategori ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => { if (result.isConfirmed) btn.closest('form').submit(); });
    }
</script>
@endsection