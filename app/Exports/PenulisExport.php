<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Crypt;
use Illuminate\Support\Facades\DB;

class PenulisExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */ use Exportable;
    public function dataExport($data)
    {
        $this->data = $data;
        return $this;
    }

    public function view(): View
    {
        $penulis=DB::select("SELECT * FROM dm_penulis");
        return view('export.exc_penulis',compact("penulis"));
    }
}
