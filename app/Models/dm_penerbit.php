<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dm_penerbit extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_dpenerbit';
    protected $table='dm_penerbits';

    protected $fillable = [
        'dpenerbit_nama_penerbit',
        'dpenerbit_alamat',
        'dpenerbit_no_kontak',
    ];
}
