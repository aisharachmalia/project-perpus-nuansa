<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Crypt;

class GuruExport implements FromView
{
    use Exportable;
    public function dataExport($data)
    {
        $this->data = $data;
        return $this;
    }

    public function view(): View
    {
        $gr = \DB::table('dm_gurus')
        ->join('dm_mapels', 'dm_gurus.id_mapel', '=', 'dm_mapels.id_mapel')
        ->select('dm_gurus.*', 'dm_mapels.dmapel_nama_mapel')
        ->get();
        
        return view('export.exc_guru',compact('gr'));
    }
}
