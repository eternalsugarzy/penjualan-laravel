<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnSupplier;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class ReturnSupplierController extends Controller
{
    // 1. TAMPILKAN RIWAYAT RETUR
    public function index()
    {
        $returns = ReturnSupplier::with(['produk', 'supplier'])->latest()->get();
        return view('admin.return.index', compact('returns'));
    }

    // 2. FORM TAMBAH RETUR
    public function create()
    {
        $suppliers = Supplier::all();
        $produks = Produk::all();
        return view('admin.return.create', compact('suppliers', 'produks'));
    }

    // 3. SIMPAN DATA & POTONG STOK
    public function store(Request $request)
    {
        $request->validate([
            'id_supplier' => 'required',
            'id_produk' => 'required',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Cek Stok Dulu (Jangan sampai retur lebih besar dari stok yg ada)
            $produk = Produk::where('id_produk', $request->id_produk)->first();
            
            if (!$produk) {
                return back()->with('error', 'Produk tidak ditemukan!');
            }

            if ($produk->stok < $request->qty) {
                return back()->with('error', 'Gagal! Jumlah retur melebihi stok yang tersedia (Stok: '.$produk->stok.')');
            }

            // Simpan Data Retur
            ReturnSupplier::create([
                'id_supplier' => $request->id_supplier,
                'id_produk' => $request->id_produk,
                'qty' => $request->qty,
                'keterangan' => $request->keterangan,
                // created_at otomatis terisi sebagai tanggal retur
            ]);

            // KURANGI STOK PRODUK
            $produk->stok -= $request->qty;
            $produk->save();

            DB::commit();
            return redirect()->route('return.index')->with('success', 'Barang berhasil diretur dan stok dikurangi.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}