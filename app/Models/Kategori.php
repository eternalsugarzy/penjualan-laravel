<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    
    // Sesuaikan dengan nama kolom primary key di database Anda
    protected $primaryKey = 'id_kategori';
    
    // Kolom yang boleh diisi
    protected $fillable = ['nama_kategori'];

    // Relasi ke Produk (One to Many)
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }
}