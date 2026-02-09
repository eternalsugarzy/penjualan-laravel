<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN BARIS INI

class TransaksiController extends Controller
{
    public function index()
    {
        $produk = DB::table('produk')->where('stok', '>', 0)->get();
        return view('admin.transaksi.index', compact('produk'));
    }

    public function store(Request $request)
    {
        // Validasi keranjang tidak boleh kosong
        if (empty($request->items)) {
            return response()->json(['message' => 'Keranjang masih kosong!'], 422);
        }

        DB::beginTransaction();
        try {
            $id_transaksi = 'TRX-' . strtoupper(Str::random(8));
            
            // 1. Simpan ke tabel Transaksi
            DB::table('transaksi')->insert([
                'id_transaksi' => $id_transaksi,
                'user_id' => auth()->id(),
                'tgl_transaksi' => now(),
                'total_harga' => $request->total_harga,
                'status' => 'selesai'
            ]);

            // 2. Simpan Detail & Update Stok
            foreach ($request->items as $item) {
                DB::table('transaksi_details')->insert([
                    'id_transaksi' => $id_transaksi,
                    'id_produk' => $item['id_produk'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal']
                ]);

                // Kurangi Stok
                DB::table('produk')->where('id_produk', $item['id_produk'])->decrement('stok', $item['qty']);
            }

            DB::commit();
            return response()->json(['message' => 'Transaksi Berhasil!', 'id' => $id_transaksi]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
public function history()
{
    $riwayat = DB::table('transaksi')
        ->where('user_id', Auth::id())
        ->orderBy('tgl_transaksi', 'desc')
        ->get();

    return view('admin.transaksi.history', compact('riwayat'));
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
}