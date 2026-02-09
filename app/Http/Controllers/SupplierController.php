<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier; // Pastikan Model di-import

class SupplierController extends Controller
{
    // 1. TAMPILKAN DAFTAR SUPPLIER
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.supplier.index', compact('suppliers'));
    }

    // 2. SIMPAN SUPPLIER BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'telp'          => 'required|string|max:20',
            'alamat'        => 'required|string',
        ]);

        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'telp'          => $request->telp,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Supplier berhasil ditambahkan!');
    }

    // 3. UPDATE SUPPLIER (INI YANG HILANG SEBELUMNYA)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'telp'          => 'required|string|max:20',
            'alamat'        => 'required|string',
        ]);

        // Cari data berdasarkan id_supplier
        // Kita gunakan where() agar aman jika Primary Key di Model belum disetting
        $supplier = Supplier::where('id_supplier', $id)->firstOrFail();

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'telp'          => $request->telp,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Supplier berhasil diperbarui!');
    }

    // 4. HAPUS SUPPLIER
    public function destroy($id)
    {
        try {
            $supplier = Supplier::where('id_supplier', $id)->firstOrFail();
            $supplier->delete();

            return redirect()->back()->with('success', 'Supplier berhasil dihapus!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Cegah hapus jika supplier sudah pernah dipakai transaksi
            if ($e->getCode() == "23000") {
                return redirect()->back()->with('error', 'Gagal menghapus! Supplier ini memiliki riwayat transaksi.');
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}