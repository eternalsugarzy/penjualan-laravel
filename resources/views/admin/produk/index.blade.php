@extends('layouts.app')

@section('title', 'Data Produk')
@section('header', 'Manajemen Stok Produk')

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
                    Email: <span class="underline text-blue-900 leading-tight">dlh.banjarmasin@gmail.com</span>
                </p>
            </div>
        </div>
        <div class="text-center mt-4">
            <h2 class="text-lg font-bold uppercase underline underline-offset-4 font-sans">LAPORAN REKAPITULASI STOK BARANG</h2>
            <p class="text-sm mt-1 font-bold font-sans">Per Tanggal: {{ date('d F Y') }}</p>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. TAMPILAN WEB & DATA TABEL               --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden print:border-0 print:shadow-none print:rounded-none">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center no-print">
            <h3 class="font-bold text-slate-700">Daftar Barang</h3>
            <div class="flex gap-2">
                <button onclick="window.print()" class="bg-slate-100 text-slate-700 px-5 py-2 rounded-xl font-bold hover:bg-slate-200 transition">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
                <button onclick="toggleModal('modalProduk')" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> Produk Baru
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto print:overflow-visible">
            <table class="w-full text-sm print:text-black">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] print:bg-slate-100 print:text-black">
                    <tr>
                        <th class="p-4 text-left print:border print:border-black print:p-2 print:text-center">No</th>
                        <th class="p-4 text-left print:border print:border-black print:p-2">Kode Barang</th>
                        <th class="p-4 text-left print:border print:border-black print:p-2">Nama Produk</th>
                        <th class="p-4 text-left print:border print:border-black print:p-2">Kategori</th>
                        <th class="p-4 text-right print:border print:border-black print:p-2">Harga Jual</th>
                        <th class="p-4 text-center print:border print:border-black print:p-2">Stok</th>
                        <th class="p-4 text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 print:divide-none">
                    @forelse($produk as $index => $p)
                    <tr class="hover:bg-slate-50 transition print:hover:bg-transparent">
                        <td class="p-4 text-slate-500 print:border print:border-black print:p-2 print:text-center">{{ $index + 1 }}</td>
                        <td class="p-4 font-mono text-xs print:border print:border-black print:p-2 uppercase">{{ $p->id_produk }}</td>
                        <td class="p-4 font-bold text-slate-800 print:text-black print:border print:border-black print:p-2">{{ $p->nama_produk }}</td>
                        <td class="p-4 text-slate-500 print:text-black print:border print:border-black print:p-2">
                            {{ $p->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                        </td>
                        <td class="p-4 font-bold text-slate-800 text-right print:text-black print:border print:border-black print:p-2">
                            Rp{{ number_format($p->harga_jual, 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-center print:border print:border-black print:p-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $p->stok < 10 ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }} print:bg-transparent print:text-black print:p-0 print:text-sm">
                                {{ $p->stok }} UNIT
                            </span>
                        </td>
                        <td class="p-4 text-center no-print">
                            <div class="flex justify-center gap-2">
                                <button onclick="editProduk(this)" data-id="{{ $p->id_produk }}" data-nama="{{ $p->nama_produk }}" data-kategori="{{ $p->id_kategori }}" data-stok="{{ $p->stok }}" data-beli="{{ $p->harga_beli }}" data-jual="{{ $p->harga_jual }}" class="text-amber-400 hover:text-amber-600 transition bg-amber-50 p-2 rounded-lg" title="Edit"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('produk.destroy', $p->id_produk) }}" method="POST" class="inline form-delete">@csrf @method('DELETE')<button type="button" onclick="confirmDelete(this)" class="text-red-400 hover:text-red-600 transition bg-red-50 p-2 rounded-lg" title="Hapus"><i class="fas fa-trash-alt"></i></button></form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="p-10 text-center text-slate-400">Belum ada data produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 3. TANDA TANGAN (HANYA MUNCUL SAAT PRINT)  --}}
    {{-- ========================================== --}}
    
</div>

{{-- ========================================== --}}
{{-- 4. MODAL TAMBAH & EDIT (NO PRINT)          --}}
{{-- ========================================== --}}
<div id="modalProduk" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50 no-print">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden animate-fade-in-down max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b flex justify-between items-center bg-blue-50 sticky top-0 bg-white z-10">
            <h3 class="font-black text-slate-800 uppercase tracking-tight">Tambah Produk Baru</h3>
            <button onclick="toggleModal('modalProduk')" class="text-slate-400 hover:text-red-500 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="p-6 grid grid-cols-2 gap-4">
            @csrf
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest">ID Produk / SKU</label>
                <input type="text" name="id_produk" class="w-full border-slate-200 rounded-xl p-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none border transition" placeholder="Contoh: BRG001" required>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest">Nama Barang</label>
                <input type="text" name="nama_produk" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none border transition" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest">Kategori</label>
                <select name="id_kategori" class="w-full border-slate-200 rounded-xl p-3 outline-none border bg-white transition focus:ring-2 focus:ring-blue-500">
                    <option value="" selected disabled> -- Pilih Kategori -- </option>
                    @foreach($kategori as $cat)
                        <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest">Stok Awal</label>
                <input type="number" name="stok" class="w-full border-slate-200 rounded-xl p-3 outline-none border transition focus:ring-2 focus:ring-blue-500" value="0" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest">Harga Beli</label>
                <input type="number" name="harga_beli" class="w-full border-slate-200 rounded-xl p-3 outline-none border transition focus:ring-2 focus:ring-blue-500" placeholder="0">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest">Harga Jual</label>
                <input type="number" name="harga_jual" class="w-full border-slate-200 rounded-xl p-3 outline-none border transition focus:ring-2 focus:ring-blue-500" placeholder="0" required>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest">Foto Produk</label>
                <input type="file" name="gambar" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div class="col-span-2 pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-200 hover:bg-blue-700 transition uppercase tracking-widest">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50 no-print">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden animate-fade-in-down max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b flex justify-between items-center bg-amber-50 sticky top-0 bg-white z-10">
            <h3 class="font-black text-slate-800 uppercase tracking-tight">Edit Produk</h3>
            <button onclick="toggleModal('modalEdit')" class="text-slate-400 hover:text-red-500 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditProduk" method="POST" enctype="multipart/form-data" class="p-6 grid grid-cols-2 gap-4">
            @csrf @method('PUT')
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ID Produk (Tidak bisa diubah)</label>
                <input type="text" id="edit_id" name="id_produk" class="w-full border-slate-200 rounded-xl p-3 bg-slate-100 text-slate-500 cursor-not-allowed border" readonly>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Nama Barang</label>
                <input type="text" id="edit_nama" name="nama_produk" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 outline-none border transition" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Kategori</label>
                <select id="edit_kategori" name="id_kategori" class="w-full border-slate-200 rounded-xl p-3 outline-none border bg-white transition focus:ring-2 focus:ring-amber-500">
                    @foreach($kategori as $cat)
                        <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Stok</label>
                <input type="number" id="edit_stok" name="stok" class="w-full border-slate-200 rounded-xl p-3 outline-none border transition focus:ring-2 focus:ring-amber-500" required>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Harga Beli</label>
                <input type="number" id="edit_beli" name="harga_beli" class="w-full border-slate-200 rounded-xl p-3 outline-none border transition focus:ring-2 focus:ring-amber-500">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Harga Jual</label>
                <input type="number" id="edit_jual" name="harga_jual" class="w-full border-slate-200 rounded-xl p-3 outline-none border transition focus:ring-2 focus:ring-amber-500" required>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest">Ganti Foto (Opsional)</label>
                <input type="file" name="gambar" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
            </div>
            <div class="col-span-2 pt-4">
                <button type="submit" class="w-full bg-amber-500 text-white py-4 rounded-2xl font-black shadow-lg shadow-amber-200 hover:bg-amber-600 transition uppercase tracking-widest">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>

{{-- STYLE PRINT FORMAL --}}
<style>
    @media print {
        @page { size: A4; margin: 1.5cm; }
        body { background: white !important; -webkit-print-color-adjust: exact; font-family: 'Times New Roman', serif; }
        .no-print, header, aside, button, form, .modal { display: none !important; }
        #kop-surat, .print-footer { display: block !important; }
        .print-footer { display: grid !important; }
        
        /* Maksa tabel jadi format kotak-kotak resmi */
        table { border-collapse: collapse !important; width: 100% !important; margin-top: 10px; table-layout: fixed; }
        th, td { 
            border: 1px solid black !important;
            padding: 8px !important;
            color: black !important;
            word-wrap: break-word;
        }
        thead th { background-color: #f2f2f2 !important; font-weight: bold !important; text-align: center !important; -webkit-print-color-adjust: exact; }
        
        .font-serif { font-family: 'Times New Roman', Times, serif !important; }
        .font-sans { font-family: Arial, Helvetica, sans-serif !important; }
    }
</style>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if(modal) modal.classList.toggle('hidden');
    }

    function editProduk(btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const kategori = btn.getAttribute('data-kategori');
        const stok = btn.getAttribute('data-stok');
        const beli = btn.getAttribute('data-beli');
        const jual = btn.getAttribute('data-jual');

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_kategori').value = kategori;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('edit_beli').value = beli;
        document.getElementById('edit_jual').value = jual;

        const form = document.getElementById('formEditProduk');
        form.action = "{{ url('produk') }}/" + id;

        toggleModal('modalEdit');
    }

    function confirmDelete(btn) {
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('.form-delete').submit();
            }
        });
    }

    @if($errors->any())
        let errorMessages = '';
        @foreach($errors->all() as $error) errorMessages += '• {{ $error }}\n'; @endforeach
        Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Periksa inputan Anda.', footer: '<pre style="text-align:left; color:red">' + errorMessages + '</pre>' });
    @endif

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif
</script>
@endsection