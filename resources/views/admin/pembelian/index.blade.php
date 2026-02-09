@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Pembelian Stok</h1>
            <p class="text-slate-500 text-sm">Data riwayat kulakan barang dari supplier</p>
        </div>
        <a href="{{ route('pembelian.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-lg shadow-blue-500/30">
            <i class="fas fa-plus"></i> Kulakan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-4 font-bold border border-emerald-200">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-4 font-bold border border-red-200">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold">
                <tr>
                    <th class="p-4 border-b w-10">No</th>
                    <th class="p-4 border-b">Tanggal</th>
                    <th class="p-4 border-b">Supplier</th>
                    <th class="p-4 border-b">No Faktur</th>
                    <th class="p-4 border-b">Total Belanja</th>
                    <th class="p-4 border-b text-center">Status</th>
                    <th class="p-4 border-b text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse($pembelian as $index => $item)
                <tr class="hover:bg-slate-50 border-b last:border-b-0 transition">
                    <td class="p-4 text-center">{{ $index + 1 }}</td>
                    <td class="p-4 font-medium">{{ date('d M Y', strtotime($item->tgl_beli)) }}</td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $item->supplier->nama_supplier ?? 'Tanpa Nama' }}</div>
                    </td>
                    <td class="p-4 text-slate-500 font-mono text-xs">
                        {{ $item->no_faktur ?? '-' }}
                    </td>
                    <td class="p-4 font-bold text-blue-600">
                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-center">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                    </td>
                    
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('pembelian.edit', $item->id) }}" class="text-amber-500 hover:text-amber-700 transition" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('pembelian.destroy', $item->id) }}" method="POST" class="inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="text-red-500 hover:text-red-700 transition" title="Hapus Data">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400">
                        <div class="mb-2"><i class="fas fa-box-open text-4xl"></i></div>
                        Belum ada data pembelian stok.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

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