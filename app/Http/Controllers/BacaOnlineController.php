<?php

namespace App\Http\Controllers;

use App\Models\baca_online;
use App\Models\dm_buku;
use Illuminate\Http\Request;

class BacaOnlineController extends Controller
{
    public function documentDetail($id = null)
    {
        $bk = \DB::select(
            "SELECT dm_buku.*,                                         
                            dm_penulis.dpenulis_nama_penulis, 
                            dm_penerbits.dpenerbit_nama_penerbit
                    FROM dm_buku 
                    LEFT JOIN dm_penulis ON dm_buku.id_dpenulis = dm_penulis.id_dpenulis 
                    LEFT JOIN dm_penerbits ON dm_buku.id_dpenerbit = dm_penerbits.id_dpenerbit 
                    WHERE dm_buku.id_dbuku = $id; 
        
        "
        );
        ;
        return view(
            'data_master.buku.baca_online',
            ['bk' => $bk[0],]
        );
    }
}
