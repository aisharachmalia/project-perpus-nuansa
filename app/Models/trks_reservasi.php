<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trks_reservasi extends Model
{
    use HasFactory;
    protected $table = 'trks_reservasi';
    protected $primaryKey = 'id_trsv';

    protected $fillable = [
        'id_usr',
        'id_dbuku',
        'id_dsbuku',
        'trsv_tgl_reservasi',
        'trsv_tgl_kadaluarsa',
        'trsv_tgl_pemberitahuan',
        'trsv_tgl_pengembalian',
        'trsv_status',
    ];
}
