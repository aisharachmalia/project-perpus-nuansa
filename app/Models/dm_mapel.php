<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dm_mapel extends Model
{
    use HasFactory;

    protected $table = 'dm_mapels';
    protected $primaryKey = 'id_mapel';
    protected $fillable = [
        'id_mapel',
        'dmapel_nama_mapel',
    ];
}
