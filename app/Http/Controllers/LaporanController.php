<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default tanggal: Awal bulan ini s/d Hari ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Ambil data transaksi berdasarkan rentang tanggal
        $transaksi = Transaksi::whereDate('tgl_transaksi', '>=', $startDate)
                        ->whereDate('tgl_transaksi', '<=', $endDate)
                        ->where('status', 'selesai') // Hanya yang status selesai
                        ->orderBy('tgl_transaksi', 'desc')
                        ->get();

        // Hitung Ringkasan
        $totalPendapatan = $transaksi->sum('total_harga');
        $totalTransaksi = $transaksi->count();

        return view('admin.laporan.index', compact('transaksi', 'startDate', 'endDate', 'totalPendapatan', 'totalTransaksi'));
    }

    public function cetak(Request $request)
    {
        // Logika cetak PDF bisa ditambahkan di sini (opsional)
        // Untuk sekarang kita pakai window.print() di view saja
    }
}