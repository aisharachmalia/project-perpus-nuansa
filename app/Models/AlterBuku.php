<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlterBuku extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini
    protected $table = 'dm_buku';

    // Daftar kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'dbuku_judul',
        'dbuku_cover',
        'dbuku_bahasa',
        'dbuku_file',
        'dbuku_link',
        'dbuku_flag',
        'dbuku_status',
    ];
}
