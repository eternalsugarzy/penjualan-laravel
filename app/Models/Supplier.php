<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // 1. Nama Tabel di Database
    protected $table = 'suppliers';

    // 2. Primary Key (PENTING: Karena di SQL Anda namanya 'id_supplier')
    protected $primaryKey = 'id_supplier';

    // 3. Kolom yang boleh diisi
    protected $guarded = [];

    // 4. Matikan timestamp jika tabel suppliers tidak punya kolom created_at/updated_at
    // (Cek di SQL Anda, tabel suppliers tidak punya kolom timestamp, jadi ini WAJIB false)
    public $timestamps = false; 
}