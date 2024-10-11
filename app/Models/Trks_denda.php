<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trks_denda extends Model
{
    use HasFactory;
    protected $table = 'trks_denda';
    protected $primaryKey = 'id_tdenda';

    protected $fillable = [
        'id_tdenda',
        'id_trks',
        'tdenda_jumlah',
        'tdenda_tgl_bayar',
        'tdenda_status',
    ];
}
