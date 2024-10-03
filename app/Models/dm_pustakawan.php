<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dm_pustakawan extends Model
{
    use HasFactory;
    protected $table = 'dm_pustakawan';
    protected $primaryKey = 'id_dpustakawan';

    protected $fillable = [
        'dpustakawan_nama',
        'dpustakawan_email',
        'dpustakawan_no_telp',
        'dpustakawan_alamat',
        'dpustakawan_status',
    ];
}
