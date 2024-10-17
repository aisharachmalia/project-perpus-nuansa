<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'trks_transaksi';
    protected $primaryKey = 'id_trks';



    protected $fillable = [
        'id_dbuku',
        'id_dsiswa',
        'id_dpustakawan',
        'trks_tgl_peminjaman',
        'trks_tgl_jatuh_tempo',
        'trks_tgl_pengembalian',
        'trks_denda',
        'trks_keterangan',
    ];
}
