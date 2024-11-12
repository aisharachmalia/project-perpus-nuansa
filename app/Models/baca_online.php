<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class baca_online extends Model
{
    use HasFactory;

    protected $table = "baca_online";
    protected $primaryKey = "id_baca_online";

    protected $fillable = [
        'id_dbuku',
        'id_usr',
        'tgl_mulai_baca',
        'tgl_selesai_baca',
        'status_baca',
    ];
}
