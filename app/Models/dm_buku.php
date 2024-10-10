<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dm_buku extends Model
{
    use HasFactory;

    protected $table = 'dm_buku';
    protected $primaryKey = 'id_dbuku';

    protected $fillable = [
        'dbuku_cover',
        'dbuku_judul',
        'id_dpenulis',
        'id_dpenerbit',
        'id_dkategori',
        'id_dmapel',
        'dbuku_thn_terbit',
        'dbuku_isbn',
        'dbuku_jml_tersedia',
        'dbuku_jml_total',
        'dbuku_lokasi_rak',
        'dbuku_edisi',
        'dbuku_bahasa',
        'dbuku_status',
    ];
}
