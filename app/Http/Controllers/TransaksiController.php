<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// --- TAMBAHKAN BARIS-BARIS INI ---
use App\Models\Transaksi;
use App\Models\TransaksiDetail; // Sesuaikan dengan nama Model detail Anda
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class TransaksiController extends Controller
{
    public function index()
    {
        $produk = DB::table('produk')->where('stok', '>', 0)->get();
        return view('admin.transaksi.index', compact('produk'));
    }

   public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'items' => 'required|array',
            'items.*.id_produk' => 'required',
            'items.*.qty' => 'required|integer|min:1',
            'total_harga' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            // 2. Buat ID Transaksi Unik
            // Contoh: TRX-20231025-ABCD
            $id_transaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            // 3. Simpan Header Transaksi
            $transaksi = Transaksi::create([
                'id_transaksi' => $id_transaksi,
                'user_id' => Auth::id(), // Pastikan user sedang login
                'tgl_transaksi' => now(),
                'total_harga' => $request->total_harga,
                'status' => 'selesai'
            ]);

            // 4. Simpan Detail & Kurangi Stok
            foreach ($request->items as $item) {
                
                // Pastikan produk ada sebelum disimpan
                $produk = Produk::where('id_produk', $item['id_produk'])->first();
                if (!$produk) {
                    throw new \Exception("Produk dengan ID " . $item['id_produk'] . " tidak ditemukan.");
                }

                // Cek stok lagi agar aman
                if ($produk->stok < $item['qty']) {
                    throw new \Exception("Stok barang " . $produk->nama_produk . " tidak cukup!");
                }

                // Simpan ke tabel detail
                // SESUAIKAN NAMA MODEL ANDA (TransaksiDetail atau TransaksiDetails)
                TransaksiDetail::create([
                    'id_transaksi' => $id_transaksi,
                    'id_produk'    => $item['id_produk'],
                    'nama_produk'  => $item['nama_produk'], // <--- INI YG ANDA MINTA
                    'qty'          => $item['qty'],
                    'harga_satuan' => $item['harga_jual'], // Mapping: JS kirim 'harga_jual', DB simpan 'harga_satuan'
                    'subtotal'     => $item['subtotal']
                ]);

                // Kurangi Stok
                $produk->decrement('stok', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan',
                'id_transaksi' => $id_transaksi
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            // Kirim pesan error asli agar terbaca di Inspect Element
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
public function history()
    {
        // Ambil data transaksi beserta user dan detail produknya
        $transaksi = Transaksi::with(['user', 'details']) // <-- Load relasi 'details'
                        ->orderBy('tgl_transaksi', 'desc')
                        ->get();

        return view('admin.transaksi.history', compact('transaksi'));
    }
public function show($id)
{
    // 1. Ambil data transaksi utama
    $transaksi = DB::table('transaksi')->where('id_transaksi', $id)->first();

    // 2. Ambil detail barang yang dibeli (join dengan tabel produk untuk ambil nama produk)
    $details = DB::table('transaksi_details')
        ->join('produk', 'transaksi_details.id_produk', '=', 'produk.id_produk')
        ->where('id_transaksi', $id)
        ->select('transaksi_details.*', 'produk.nama_produk')
        ->get();

    // 3. Ambil data profil toko
    $toko = DB::table('toko')->first();

    return view('admin.transaksi.print', compact('transaksi', 'details', 'toko'));
}

public function cetak($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::with(['details', 'user'])->findOrFail($id);
        
        // Tampilkan view cetak (struk)
        return view('admin.transaksi.print', compact('transaksi'));
    }
}