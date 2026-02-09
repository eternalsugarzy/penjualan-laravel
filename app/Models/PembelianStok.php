<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianStok extends Model
{
    use HasFactory;

    // Beritahu Laravel nama tabelnya (karena tidak standar pakai 's')
    protected $table = 'pembelian_stok';
    
    // Kolom yang boleh diisi
    protected $guarded = [];

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id_supplier');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Detail
    public function details()
    {
        // Parameter kedua adalah nama kolom FK di tabel detail
        return $this->hasMany(PembelianStokDetail::class, 'pembelian_stok_id'); 
    }
}