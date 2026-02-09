<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    public function index()
    {
        // UBAH DISINI: Kita urutkan berdasarkan Nama Produk saja (A-Z)
        // karena tabel produk tidak punya kolom 'created_at'
        $produk = Produk::with('kategori')->orderBy('nama_produk', 'asc')->get();
        
        $kategori = Kategori::all();
        
        return view('admin.produk.index', compact('produk', 'kategori'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'id_produk'   => 'required|unique:produk,id_produk|max:50',
            'nama_produk' => 'required|max:255',
            'id_kategori' => 'nullable',
            'stok'        => 'required|integer|min:0',
            'harga_beli'  => 'nullable|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'id_produk.unique' => 'Kode Produk (ID) ini sudah dipakai. Gunakan kode lain.',
            'id_produk.required' => 'Kode Produk wajib diisi.',
            'gambar.max'       => 'Ukuran foto terlalu besar (Max 2MB).',
            'gambar.image'     => 'File harus berupa gambar.'
        ]);

        try {
            // 2. Siapkan Folder Gambar
            $path = public_path('images/produk');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // 3. Proses Upload Gambar
            $nama_gambar = null; 
            
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $nama_gambar = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $nama_gambar);
            }

            // 4. Simpan ke Database
            Produk::create([
                'id_produk'   => $request->id_produk,
                'nama_produk' => $request->nama_produk,
                'id_kategori' => $request->id_kategori,
                'stok'        => $request->stok,
                'harga_beli'  => $request->harga_beli ?? 0,
                'harga_jual'  => $request->harga_jual,
                'gambar'      => $nama_gambar // Simpan nama file atau null
            ]);

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Gagal Simpan: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga_jual'  => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|max:2048'
        ]);

        try {
            $produk = Produk::findOrFail($id);
            $data = $request->all();

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($produk->gambar && File::exists(public_path('images/produk/'.$produk->gambar))) {
                    File::delete(public_path('images/produk/'.$produk->gambar));
                }

                $file = $request->file('gambar');
                $nama_gambar = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/produk'), $nama_gambar);
                
                $data['gambar'] = $nama_gambar;
            }

            $produk->update($data);

            return redirect()->back()->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);

            // Hapus file gambar dari folder
            if ($produk->gambar && File::exists(public_path('images/produk/'.$produk->gambar))) {
                File::delete(public_path('images/produk/'.$produk->gambar));
            }

            $produk->delete();
            return redirect()->back()->with('success', 'Produk dihapus!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus! Produk ini mungkin sedang digunakan di transaksi.');
        }
    }
}