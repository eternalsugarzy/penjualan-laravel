<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_produk'    => DB::table('produk')->count(),
            'total_kategori'  => DB::table('kategori')->count(),
            'total_supplier'  => DB::table('suppliers')->count(),
            'total_transaksi' => DB::table('transaksi')->count(),
        ];

        return view('admin.dashboard', $data);
    }
}