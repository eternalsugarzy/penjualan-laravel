<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnSupplier extends Model
{
    use HasFactory;

    protected $table = 'return_suppliers'; // Nama tabel di SQL
    protected $primaryKey = 'id_return_s'; // Primary Key
    protected $guarded = []; // Boleh isi semua
    
    // Matikan timestamp jika di tabel tidak ada kolom created_at
    // Tapi sebaiknya dihidupkan jika Anda pakai migration Laravel. 
    // Jika error "Unknown column updated_at", ubah jadi false.
    public $timestamps = true; 

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}