<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dm_siswa extends Model
{

    protected $table = 'dm_siswas';
    protected $primaryKey = 'id_dsiswa';
    
    use HasFactory;
    protected $fillable = [
        'id_dsiswa',
        'dsiswa_nama',
        'dsiswa_nis',
        'dsiswa_email',
        'dsiswa_no_telp',
        'dsiswa_alamat',
        'dsiswa_sts',
        'id_dkelas',
        'dsiswa_flag',
        'id_usr',
    ];
}
