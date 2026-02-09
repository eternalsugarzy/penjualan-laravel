<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    public function index() {
        $bank = DB::table('bank')->get();
        return view('admin.bank.index', compact('bank'));
    }

    public function store(Request $request) {
        DB::table('bank')->insert([
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'atas_nama' => $request->atas_nama
        ]);
        return back()->with('success', 'Rekening bank berhasil didaftarkan!');
    }

    public function destroy($id) {
        DB::table('bank')->where('id_bank', $id)->delete();
        return back()->with('success', 'Data bank dihapus!');
    }
}