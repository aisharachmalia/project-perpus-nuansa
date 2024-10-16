<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dm_kategori extends Model
{
    use HasFactory; 
    protected $table = 'dm_kategoris';
    protected $primaryKey = 'id_dkategori';
    protected $fillable = [
        'dkategori_nama_kategori',
    ];
}
