<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokoController extends Controller
{
    public function index()
    {
        // Ambil data toko pertama (asumsi hanya ada 1 toko)
        $toko = DB::table('toko')->first();
        return view('admin.toko.index', compact('toko'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required',
            'deskripsi' => 'required'
        ]);

        DB::table('toko')->updateOrInsert(
            ['id_toko' => 1], // Key untuk cek data
            [
                'nama_toko' => $request->nama_toko,
                'deskripsi' => $request->deskripsi
            ]
        );

        return back()->with('success', 'Informasi toko berhasil diperbarui!');
    }
}