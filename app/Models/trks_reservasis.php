<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trks_reservasis extends Model
{
    use HasFactory;
    protected $table = 'trks_reservasis';
    protected $primaryKey = 'id_trsv';

    protected $fillable = [
        'id_usr',
        'id_dbuku',
        'id_dsbuku',
        'trsv_tgl_reservasi',
        'trsv_tgl_kadaluarsa',
        'trsv_tgl_pemberitahuan',
        'trsv_tgl_pengambilan',
        'trsv_status',
    ];
}
