<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akses_usr extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_usr',
        'id_role',
        'id_menu',
        'hak_akses'
    ];
}
