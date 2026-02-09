<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        // Join ke kategori untuk mengambil nama kategorinya
        $produk = DB::table('produk')
            ->leftJoin('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
            ->select('produk.*', 'kategori.nama_kategori')
            ->get();
            
        $kategori = DB::table('kategori')->get();
        return view('admin.produk.index', compact('produk', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|unique:produk',
            'nama_produk' => 'required',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $namaGambar = 'default.png';
        if ($request->hasFile('gambar')) {
            $namaGambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/produk'), $namaGambar);
        }

        DB::table('produk')->insert([
            'id_produk' => $request->id_produk,
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'harga_beli' => $request->harga_beli ?? 0,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'gambar' => $namaGambar
        ]);

        return back()->with('success', 'Produk berhasil ditambah!');
    }

    public function destroy($id)
    {
        $produk = DB::table('produk')->where('id_produk', $id)->first();
        if($produk->gambar != 'default.png'){
            @unlink(public_path('images/produk/'.$produk->gambar));
        }
        
        DB::table('produk')->where('id_produk', $id)->delete();
        return back()->with('success', 'Produk dihapus!');
    }
}