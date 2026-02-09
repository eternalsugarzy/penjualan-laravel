@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('header', 'Rekapitulasi Keuangan')

@section('content')
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
    </div>

    {{-- Judul Laporan saat Print --}}
    <div class="hidden print-title text-center mb-6 font-sans">
        <h2 class="text-lg font-bold uppercase underline underline-offset-4">LAPORAN REKAPITULASI PENJUALAN</h2>
        <p class="text-sm mt-1 font-bold">Periode: {{ date('d F Y', strtotime($startDate)) }} s/d {{ date('d F Y', strtotime($endDate)) }}</p>
    </div>


    {{-- ========================================== --}}
    {{-- 2. KONTEN WEB (AKAN HILANG SAAT PRINT)     --}}
    {{-- ========================================== --}}
    <div class="no-print grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-3xl p-6 text-white shadow-lg shadow-blue-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-xs font-bold uppercase tracking-wider">Total Pendapatan</p>
                    <h3 class="text-3xl font-black mt-1">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/20 p-3 rounded-xl"><i class="fas fa-wallet text-2xl"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Transaksi</p>
                    <h3 class="text-3xl font-black mt-1 text-slate-800">{{ $totalTransaksi }}</h3>
                </div>
                <div class="bg-emerald-100 text-emerald-600 p-3 rounded-xl"><i class="fas fa-shopping-bag text-2xl"></i></div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Rata-rata / Nota</p>
                    @php $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0; @endphp
                    <h3 class="text-3xl font-black mt-1 text-slate-800">Rp{{ number_format($rataRata, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-xl"><i class="fas fa-chart-line text-2xl"></i></div>
            </div>
        </div>
    </div>

    <div class="no-print bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
        <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-col md:flex-row gap-4 items-end justify-between">
            <div class="flex gap-4 w-full md:w-auto">
                <div class="flex-1">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <button type="submit" class="bg-slate-800 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-slate-700 transition shadow-lg"><i class="fas fa-filter mr-2"></i> Filter</button>
                </div>
            </div>
            <button type="button" onclick="window.print()" class="bg-blue-50 text-blue-600 px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-100 transition border border-blue-200"><i class="fas fa-print mr-2"></i> Cetak Laporan</button>
        </form>
    </div>


    {{-- ========================================== --}}
    {{-- 3. TABEL DATA (MUNCUL DI WEB & PRINT)      --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden print:border-0 print:shadow-none print:rounded-none">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left print:text-xs font-sans">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] print:bg-transparent print:text-black print:border-y-2 print:border-black">
                    <tr>
                        <th class="p-4 print:p-2 print:border-black">No. Nota</th>
                        <th class="p-4 print:p-2 print:border-black">Tanggal</th>
                        <th class="p-4 print:p-2 print:border-black">Kasir</th>
                        <th class="p-4 text-right print:p-2 print:border-black">Total Belanja</th>
                        <th class="p-4 text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 print:divide-slate-300">
                    @forelse($transaksi as $trx)
                    <tr class="hover:bg-slate-50 transition print:hover:bg-transparent">
                        <td class="p-4 font-bold text-blue-600 print:text-black print:p-2 print:border-b print:border-slate-300">{{ $trx->id_transaksi }}</td>
                        <td class="p-4 text-slate-500 print:text-black print:p-2 print:border-b print:border-slate-300">{{ date('d/m/Y H:i', strtotime($trx->tgl_transaksi)) }}</td>
                        <td class="p-4 print:p-2 print:border-b print:border-slate-300">
                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-bold uppercase print:bg-transparent print:text-black print:p-0">
                                {{ $trx->user->name ?? 'Admin' }}
                            </span>
                        </td>
                        <td class="p-4 text-right font-bold text-slate-800 print:text-black print:p-2 print:border-b print:border-slate-300">Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td class="p-4 text-center no-print">
                            <a href="{{ route('transaksi.cetak', $trx->id_transaksi) }}" target="_blank" class="text-slate-400 hover:text-blue-600 transition"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">Tidak ada data transaksi pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-slate-50 border-t border-slate-200 print:bg-transparent print:border-t-2 print:border-black">
                    <tr>
                        <td colspan="3" class="p-4 font-bold text-right text-slate-600 uppercase print:text-black">Total Keseluruhan</td>
                        <td class="p-4 text-right font-black text-blue-600 text-lg print:text-black">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        <td class="no-print"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    

</div>

<style>
    @media print {
        @page { size: A4; margin: 1.5cm; }
        body { background: white; -webkit-print-color-adjust: exact; font-family: 'Times New Roman', Times, serif; }
        
        .no-print, header, aside, .sidebar, button, form { display: none !important; }

        #kop-surat { display: block !important; }
        .print-title { display: block !important; }
        .print-footer { display: grid !important; }
        
        .space-y-6 { 
            position: static; 
            width: 100%; 
            margin: 0; 
            padding: 0; 
        }

        /* Memaksa font serif untuk Kop Surat */
        #kop-surat h3, #kop-surat h2, #kop-surat p {
            font-family: 'Times New Roman', Times, serif;
        }

        /* Memaksa font sans-serif (Arial) untuk Tabel agar mudah dibaca */
        table, .print-title, .print-footer {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Styling Tabel Print yang Rapi */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead th { border-top: 2px solid black; border-bottom: 2px solid black; padding: 8px; }
        tbody td { padding: 8px; border-bottom: 1px solid #ccc; }
        tfoot td { border-top: 2px solid black; padding: 10px; }
    }
</style>
@endsection