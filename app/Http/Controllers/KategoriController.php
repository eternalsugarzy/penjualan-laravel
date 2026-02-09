<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = DB::table('kategori')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required']);
        DB::table('kategori')->insert(['nama_kategori' => $request->nama_kategori]);
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_kategori' => 'required']);
        DB::table('kategori')->where('id_kategori', $id)->update(['nama_kategori' => $request->nama_kategori]);
        return back()->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        DB::table('kategori')->where('id_kategori', $id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}