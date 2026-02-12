@extends('layouts.app')

@section('title', 'Riwayat Pembelian')
@section('header', 'Manajemen Stok Masuk')

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
            <h2 class="text-lg font-bold uppercase underline underline-offset-4 font-sans">LAPORAN RIWAYAT PEMBELIAN STOK (KULAKAN)</h2>
            <p class="text-sm mt-1 font-bold font-sans">Per Tanggal: {{ date('d F Y') }}</p>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. TAMPILAN WEB (DAFTAR PEMBELIAN)         --}}
    {{-- ========================================== --}}
    <div class="no-print flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Pembelian Stok</h1>
            <p class="text-slate-500 text-sm">Data riwayat kulakan barang dari supplier</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg font-bold hover:bg-slate-200 transition border border-slate-200">
                <i class="fas fa-print mr-2"></i> Cetak Laporan
            </button>
            <a href="{{ route('pembelian.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-lg shadow-blue-500/30">
                <i class="fas fa-plus"></i> Kulakan Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="no-print bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-4 font-bold border border-emerald-200">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200 print:border-0 print:shadow-none print:rounded-none">
        <div class="overflow-x-auto print:overflow-visible">
            <table class="w-full text-left border-collapse print:text-black">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold print:bg-slate-100 print:text-black">
                    <tr>
                        <th class="p-4 border-b w-10 print:border print:border-black print:p-2 print:text-center">No</th>
                        <th class="p-4 border-b print:border print:border-black print:p-2">Tanggal</th>
                        <th class="p-4 border-b print:border print:border-black print:p-2">Supplier</th>
                        <th class="p-4 border-b print:border print:border-black print:p-2">No Faktur</th>
                        <th class="p-4 border-b text-right print:border print:border-black print:p-2">Total Belanja</th>
                        <th class="p-4 border-b text-center print:border print:border-black print:p-2">Status</th>
                        <th class="p-4 border-b text-center w-32 no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 print:divide-none">
                    @forelse($pembelian as $index => $item)
                    <tr class="hover:bg-slate-50 border-b last:border-b-0 transition print:hover:bg-transparent">
                        <td class="p-4 text-center print:border print:border-black print:p-2">{{ $index + 1 }}</td>
                        <td class="p-4 font-medium print:border print:border-black print:p-2">{{ date('d/m/Y', strtotime($item->tgl_beli)) }}</td>
                        <td class="p-4 print:border print:border-black print:p-2">
                            <div class="font-bold text-slate-800 print:text-black uppercase">{{ $item->supplier->nama_supplier ?? 'Tanpa Nama' }}</div>
                        </td>
                        <td class="p-4 text-slate-500 font-mono text-xs print:text-black print:border print:border-black print:p-2">
                            {{ $item->no_faktur ?? '-' }}
                        </td>
                        <td class="p-4 font-bold text-blue-600 text-right print:text-black print:border print:border-black print:p-2">
                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-center print:border print:border-black print:p-2">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold print:bg-transparent print:p-0 print:text-black">Selesai</span>
                        </td>
                        
                        <td class="p-4 text-center no-print">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('pembelian.edit', $item->id) }}" class="text-amber-500 hover:text-amber-700 transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pembelian.destroy', $item->id) }}" method="POST" class="inline form-delete">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="text-red-500 hover:text-red-700 transition">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400 print:border print:border-black">
                            Belum ada data pembelian stok.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                {{-- Footer Tabel khusus Total Keseluruhan saat Print --}}
                <tfoot class="hidden print:table-footer-group">
                    <tr>
                        <td colspan="4" class="p-2 font-bold text-right border border-black">TOTAL PENGELUARAN</td>
                        <td class="p-2 font-bold text-right border border-black">Rp {{ number_format($pembelian->sum('total_harga'), 0, ',', '.') }}</td>
                        <td class="border border-black"></td>
                    </tr>
                </tfoot>
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
    function confirmDelete(btn) {
        Swal.fire({
            title: 'Batalkan Pembelian?',
            text: "Stok produk akan otomatis DIKURANGI kembali sesuai jumlah pembelian ini. Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus & Kurangi Stok!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('.form-delete').submit();
            }
        });
    }
</script>
@endsection