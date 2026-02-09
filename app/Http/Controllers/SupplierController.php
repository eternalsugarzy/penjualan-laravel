<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index() {
        $suppliers = DB::table('suppliers')->get();
        return view('admin.supplier.index', compact('suppliers'));
    }

    public function store(Request $request) {
        DB::table('suppliers')->insert([
            'nama_supplier' => $request->nama_supplier,
            'telp' => $request->telp,
            'alamat' => $request->alamat
        ]);
        return back()->with('success', 'Supplier berhasil ditambah');
    }

    public function destroy($id) {
        DB::table('suppliers')->where('id_supplier', $id)->delete();
        return back()->with('success', 'Supplier dihapus');
    }
}