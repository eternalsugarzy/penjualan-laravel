<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Import Models
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\PembelianStok;
use App\Models\PembelianStokDetail;

class PembelianController extends Controller
{
    // 1. HALAMAN RIWAYAT PEMBELIAN
    public function index()
    {
        $pembelian = PembelianStok::with('supplier')->latest()->get();
        return view('admin.pembelian.index', compact('pembelian'));
    }

    // 2. HALAMAN FORM KULAKAN BARU
    public function create()
    {
        $suppliers = Supplier::all();
        $produks = Produk::all();
        return view('admin.pembelian.create', compact('suppliers', 'produks'));
    }

    // 3. PROSES SIMPAN DATA (LOGIKA UTAMA)
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'tgl_beli'    => 'required|date',
            'produk_id'   => 'required|array',
            'qty'         => 'required|array',
            'harga_beli'  => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            // A. Simpan Header
            $pembelian = new PembelianStok();
            $pembelian->no_faktur = $request->no_faktur;
            $pembelian->supplier_id = $request->supplier_id;
            $pembelian->user_id = Auth::id();
            $pembelian->tgl_beli = $request->tgl_beli;
            $pembelian->status = 'selesai';
            $pembelian->total_harga = 0;
            $pembelian->save();

            $total_harga_semua = 0;

            // B. Simpan Detail & Update Stok
            foreach ($request->produk_id as $key => $prod_id) {
                $qty = $request->qty[$key];
                $harga = $request->harga_beli[$key];
                $subtotal = $qty * $harga;

                if($qty > 0) {
                    // 1. Masuk ke tabel detail
                    PembelianStokDetail::create([
                        'pembelian_stok_id' => $pembelian->id, // INI KOLOM YANG BENAR
                        'produk_id'         => $prod_id,
                        'qty'               => $qty,
                        'harga_beli'        => $harga,
                        'subtotal'          => $subtotal
                    ]);

                    // 2. Update Stok Produk
                    $produk = Produk::where('id_produk', $prod_id)->first();
                    if($produk) {
                        $produk->stok += $qty;
                        $produk->harga_beli = $harga;
                        $produk->save();
                    }

                    $total_harga_semua += $subtotal;
                }
            }

            // C. Update Total Harga
            $pembelian->total_harga = $total_harga_semua;
            $pembelian->save();

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Stok berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    // 4. HAPUS DATA (Void Transaksi)
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $pembelian = PembelianStok::with('details')->findOrFail($id);

            // Kembalikan Stok (Kurangi stok gudang)
            foreach ($pembelian->details as $detail) {
                $produk = Produk::find($detail->produk_id);
                if ($produk) {
                    $produk->stok -= $detail->qty;
                    $produk->save();
                }
            }

            // Hapus data
            $pembelian->details()->delete();
            $pembelian->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Data pembelian dihapus dan stok dikurangi kembali.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // 5. HALAMAN EDIT
    public function edit($id)
    {
        $pembelian = PembelianStok::with('details.produk')->findOrFail($id);
        $suppliers = Supplier::all();
        $produks = Produk::all();

        return view('admin.pembelian.edit', compact('pembelian', 'suppliers', 'produks'));
    }

    // 6. PROSES UPDATE (PERBAIKAN UTAMA ADA DISINI)
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_supplier' => 'required', // Nama input dari Form Edit
            'tgl_beli'    => 'required|date',
            'no_faktur'   => 'required|string',
            'id_produk'   => 'required|array',
            'qty'         => 'required|array',
            'harga_beli'  => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $pembelian = PembelianStok::with('details')->findOrFail($id);

            // A. RESET STOK LAMA (Kurangi stok gudang sesuai data lama)
            foreach ($pembelian->details as $detail) {
                $produk = Produk::find($detail->produk_id);
                if ($produk) {
                    $produk->stok -= $detail->qty; 
                    $produk->save();
                }
            }

            // B. HAPUS DETAIL LAMA
            $pembelian->details()->delete();

            // C. HITUNG TOTAL HARGA BARU
            $total_harga_baru = 0;
            foreach ($request->qty as $key => $val) {
                $total_harga_baru += ($request->qty[$key] * $request->harga_beli[$key]);
            }

            // D. UPDATE HEADER (FIX: Nama kolom DB disesuaikan)
            $pembelian->update([
                'supplier_id' => $request->id_supplier, // DB: supplier_id | Input: id_supplier
                'no_faktur'   => $request->no_faktur,
                'tgl_beli'    => $request->tgl_beli,
                'total_harga' => $total_harga_baru,
            ]);

            // E. SIMPAN DETAIL BARU & TAMBAH STOK BARU
            $count_produk = count($request->id_produk);
            for ($i = 0; $i < $count_produk; $i++) {
                if(isset($request->id_produk[$i])) {
                    
                    // Simpan Detail Baru (FIX: Nama kolom DB disesuaikan)
                    PembelianStokDetail::create([
                        'pembelian_stok_id' => $pembelian->id, // PENTING: Pakai pembelian_stok_id
                        'produk_id'         => $request->id_produk[$i],
                        'qty'               => $request->qty[$i],
                        'harga_beli'        => $request->harga_beli[$i],
                        'subtotal'          => $request->qty[$i] * $request->harga_beli[$i]
                    ]);

                    // Tambah Stok Baru ke Gudang
                    $produk = Produk::find($request->id_produk[$i]);
                    if ($produk) {
                        $produk->stok += $request->qty[$i];
                        $produk->harga_beli = $request->harga_beli[$i];
                        $produk->save();
                    }
                }
            }

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }
}