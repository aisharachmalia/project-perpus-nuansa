<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Crypt;

class PustakawanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function dataExport($data)
    {
        $this->data = $data;
        return $this;
    }

    public function view(): View
    {
        $pustakawan = \DB::select("SELECT * FROM dm_pustakawan WHERE deleted_at IS NULL");
        return view('export.exc_pustakawan', compact('pustakawan'));
    }
}
