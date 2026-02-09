@extends('layouts.app')

@section('title', 'Kategori')
@section('header', 'Master Kategori Produk')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider">Daftar Kategori</h3>
        <button onclick="addKategori()" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Kategori Baru
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-4 text-left w-20">No</th>
                    <th class="p-4 text-left">Nama Kategori</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($kategori as $index => $k)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 text-slate-500">{{ $index + 1 }}</td>
                    <td class="p-4 font-bold text-slate-800">{{ $k->nama_kategori }}</td>
                    <td class="p-4 text-center flex justify-center space-x-2">
                        <button onclick="editKategori('{{ $k->id_kategori }}', '{{ $k->nama_kategori }}')" class="text-amber-500 hover:bg-amber-50 w-8 h-8 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete(this)" class="text-red-400 hover:bg-red-50 w-8 h-8 rounded-lg transition">
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