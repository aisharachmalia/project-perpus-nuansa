<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dm_penulis extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_dpenulis';
    protected $table = 'dm_penulis';

    protected $fillable = [
        'dpenulis_nama_penulis',
        'dpenulis_kewarganegaraan',
        'dpenulis_tgl_lahir',
    ];
}
