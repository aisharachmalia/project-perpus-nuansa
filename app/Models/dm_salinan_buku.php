<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dm_salinan_buku extends Model
{
    use HasFactory;

    protected $table = "dm_salinan_bukus";
    protected $primaryKey = "id_dsbuku";

    protected $fillable = [
        'id_dbuku',
        'dsbuku_no_salinan',
        'dsbuku_kondisi',
        'dsbuku_status',
        'dsbuku_flag',
    ];
}
