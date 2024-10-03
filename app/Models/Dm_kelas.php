<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dm_kelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_dkelas',
        'dkelas_nama_kelas',
        'dkelas_tingkat',
        'dkelas_jurusan'
    ];

     protected $primaryKey = 'id_dkelas';
}
