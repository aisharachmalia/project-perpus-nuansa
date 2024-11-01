<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\dm_salinan_buku;

class BukuSalinanExport implements FromView
{
    use Exportable;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        // Query the database for salinan buku records based on the ID
        $salinan = dm_salinan_buku::where('id_dbuku', $this->id)->get();
    

        return view('export.exc_salinan_buku', compact('salinan'));
    }
}
