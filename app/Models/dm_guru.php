<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dm_guru extends Model
{
    use HasFactory;
    protected $table = 'dm_gurus';
    protected $primaryKey = 'id_dguru';

    protected $fillable = [
        'dguru_nama',
        'dguru_nip',
        'dguru_email',
        'dguru_no_telp',
        'dguru_alamat',
        'id_mapel',
        'dguru_status',
    ];

}
