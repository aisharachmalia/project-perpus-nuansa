<?php

namespace App\Http\Controllers;

use App\Exports\PenulisExport;
use App\Models\dm_kategori;
use App\Models\dm_penerbit;
use App\Models\dm_penulis;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ReferensiController extends Controller
{
    public function pageReferensi()
    {
        return view('data_master.referensi.index');
    }

    // controller penulis
    public function dpenulis()
    {
        if (request()->ajax()) {
            $penulis = dm_penulis::query()->where("deleted_at", null);
            return DataTables::of($penulis)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dpenulis) . '" class="btn btn-warning btn-sm modalEditPenulis mr-2" data-bs-toggle="modal" data-bs-target="#editPenulis">
                        <i class="bi bi-pencil"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dpenulis) . '" class="btn btn-primary btn-sm modalShowPenulis" data-bs-toggle="modal" data-bs-target="#showPenulis">
                        <i class="bi bi-eye"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete-penulis" data-id="' . Crypt::encryptString($row->id_dpenulis) . '" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function addPenulis(Request $request)
    {
        try {
            $rules = [
                'dpenulis_nama_penulis' => 'required|unique:dm_penulis,dpenulis_nama_penulis|regex:/^[a-zA-Z\s]+$/',
                'dpenulis_kewarganegaraan' => 'required|regex:/^[a-zA-Z\s]+$/',
                'dpenulis_tgl_lahir' => 'required',
            ];

            $messages = [
                'dpenulis_nama_penulis.required' => 'Nama harus diisi!',
                'dpenulis_kewarganegaraan.required' => 'Kewarganegaraan harus diisi!',
                'dpenulis_tgl_lahir.required' => 'Tanggal Lahir harus diisi!',
                'dpenulis_nama_penulis.unique' => 'Penulis sudah ada!',
                'dpenulis_nama_penulis.regex' => 'Nama penulis harus berupa huruf!',
                'dpenulis_kewarganegaraan.regex' => 'Kewarganegaraan harus berupa huruf!',

            ];
            $validated = $request->validate($rules, $messages);

            dm_penulis::create([
                "dpenulis_nama_penulis" => $request->dpenulis_nama_penulis,
                'dpenulis_kewarganegaraan' => $request->dpenulis_kewarganegaraan,
                'dpenulis_tgl_lahir' => $request->dpenulis_tgl_lahir,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editPenulis(Request $request, $id = null)
    {
        try {
            $id = Crypt::decryptString($id);
            $penulis = dm_penulis::find($id);
            $rules = [
                'nama_penulis' => [
                    'required',
                    Rule::unique('dm_penulis', 'dpenulis_nama_penulis')->ignore($penulis->id_dpenulis, 'id_dpenulis'),
                    'regex:/^[a-zA-Z\s]+$/'
                ],
                'dpenulis_kewarganegaraan' => 'required|regex:/^[a-zA-Z\s]+$/',
                'dpenulis_tgl_lahir' => 'required',
            ];

            $messages = [
                'nama_penulis.required' => 'Nama harus diisi!',
                'dpenulis_kewarganegaraan.required' => 'Kewarganegaraan harus diisi!',
                'dpenulis_tgl_lahir.required' => 'Tanggal Lahir harus diisi!',
                'nama_penulis.unique' => 'Penulis sudah ada!',
                'nama_penulis.regex' => 'Nama penulis harus berupa huruf!',
                'dpenulis_kewarganegaraan.regex' => 'Kewarganegaraan harus berupa huruf!',

            ];
            $validated = $request->validate($rules, $messages);

            $penulis->dpenulis_nama_penulis = $request->nama_penulis;
            $penulis->dpenulis_kewarganegaraan = $request->dpenulis_kewarganegaraan;
            $penulis->dpenulis_tgl_lahir = $request->dpenulis_tgl_lahir;
            $penulis->save();

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dirubah!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function showPenulis($id)
    {
        try {
            $id_penulis = Crypt::decryptString($id);
            $penulis = DB::table("dm_penulis")->where("id_dpenulis", $id_penulis)->select("dpenulis_nama_penulis", "dpenulis_kewarganegaraan", "dpenulis_tgl_lahir")->first();
            return response()->json($penulis);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deletePenulis($id = null)
    {
        $id_dpenulis = Crypt::decryptString($id);
        $gr = dm_penulis::find($id_dpenulis);
        $gr->deleted_at = Carbon::now();
        $gr->save();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }
    // end controler penulis


    // controller penerbit
    public function dpenerbit()
    {
        if (request()->ajax()) {
            $penerbit = dm_penerbit::query()->where("deleted_at", null);
            return DataTables::of($penerbit)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dpenerbit) . '" class="btn btn-warning btn-sm modalEditPenerbit mr-2" data-bs-toggle="modal" data-bs-target="#editPenerbit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dpenerbit) . '" class="btn btn-primary btn-sm modalShowPenerbit" data-bs-toggle="modal" data-bs-target="#showPenerbit">
                        <i class="bi bi-eye"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete-penerbit" data-id="' . Crypt::encryptString($row->id_dpenerbit) . '" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function addPenerbit(Request $request)
    {
        try {
            $rules = [
                'nama_penerbit' => 'required|unique:dm_penerbits,dpenerbit_nama_penerbit|regex:/^[a-zA-Z\s]+$/',
                'alamat' => 'required',
                'no_kontak' => 'required|numeric|digits_between:10,13',
            ];

            $messages = [
                'nama_penerbit.required' => 'Nama penerbit harus diisi!',
                'nama_penerbit.unique' => 'Nama penerbit sudah terdaftar!',
                'nama_penerbit.regex' => 'Nama penerbit hanya boleh berisi huruf dan spasi!',
                'alamat.required' => 'Alamat harus diisi!',
                'no_kontak.required' => 'Nomor kontak harus diisi!',
                'no_kontak.numeric' => 'Nomor kontak harus berupa angka!',
                'no_kontak.digits_between' => 'Nomor kontak harus berisi antara 10 hingga 13 digit!',
            ];

            $validated = $request->validate($rules, $messages);

            dm_penerbit::create([
                "dpenerbit_nama_penerbit" => $request->nama_penerbit,
                'dpenerbit_alamat' => $request->alamat,
                'dpenerbit_no_kontak' => $request->no_kontak
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editPenerbit(Request $request, $id = null)
    {
        try {
            $id = Crypt::decryptString($id);
            $penerbit = dm_penerbit::find($id);
            $rules = [
                'nama_penerbit' => [
                    'required',
                    Rule::unique('dm_penerbits', 'dpenerbit_nama_penerbit')->ignore($penerbit->id_dpenerbit, 'id_dpenerbit'),
                    'regex:/^[a-zA-Z\s]+$/'
                ],
                'alamat' => 'required',
                'no_kontak' => 'required|numeric|digits_between:10,13',
            ];

            $messages = [
                'nama_penerbit.required' => 'Nama penerbit harus diisi!',
                'nama_penerbit.unique' => 'Nama penerbit sudah terdaftar!',
                'nama_penerbit.regex' => 'Nama penerbit hanya boleh berisi huruf!',
                'alamat.required' => 'Alamat harus diisi!',
                'no_kontak.required' => 'Nomor kontak harus diisi!',
                'no_kontak.numeric' => 'Nomor kontak harus berupa angka!',
                'no_kontak.digits_between' => 'Nomor kontak harus berisi antara 10 hingga 13 digit!',
            ];

            $validated = $request->validate($rules, $messages);

            $penerbit->dpenerbit_nama_penerbit = $request->nama_penerbit;
            $penerbit->dpenerbit_alamat = $request->alamat;
            $penerbit->dpenerbit_no_kontak = $request->no_kontak;
            $penerbit->save();

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dirubah!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function showPenerbit($id)
    {
        try {
            $id_penerbit = Crypt::decryptString($id);
            $penerbit = DB::table("dm_penerbits")->where("id_dpenerbit", $id_penerbit)->select("dpenerbit_nama_penerbit", "dpenerbit_alamat", "dpenerbit_no_kontak")->first();
            return response()->json($penerbit);
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    public function deletePenerbit($id = null)
    {
        $id_dpenerbit = Crypt::decryptString($id);
        $penerbit = dm_penerbit::find($id_dpenerbit);
        $penerbit->deleted_at = Carbon::now();
        $penerbit->save();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }
    // end controler penerbit

    // Controller kategori
    public function dkategori()
    {
        if (request()->ajax()) {
            $kategori = dm_kategori::query()->where("deleted_at", null);
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dkategori) . '" class="btn btn-warning btn-sm modalEditKategori mr-2" data-bs-toggle="modal" data-bs-target="#editKategori">
                        <i class="bi bi-pencil"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dkategori) . '" class="btn btn-primary btn-sm modalShowKategori" data-bs-toggle="modal" data-bs-target="#showKategori">
                        <i class="bi bi-eye"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete-kategori" data-id="' . Crypt::encryptString($row->id_dkategori) . '" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function addKategori(Request $request)
    {
        try {
            $rules = [
                'nama_kategori' => 'required|unique:dm_kategoris,dkategori_nama_kategori|regex:/^[a-zA-Z\s]+$/',
            ];

            $messages = [
                'nama_kategori.required' => 'Nama kategori harus diisi!',
                'nama_kategori.unique' => 'Nama kategori sudah terdaftar!',
                'nama_kategori.regex' => 'Nama kategori hanya boleh berisi huruf dan spasi!',
            ];

            $validated = $request->validate($rules, $messages);

            dm_kategori::create([
                "dkategori_nama_kategori" => $request->nama_kategori,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editKategori(Request $request, $id = null)
    {
        try {
            $id = Crypt::decryptString($id);
            $penerbit = dm_kategori::find($id);
            $rules = [
                'nama_kategori' => [
                    'required',
                    Rule::unique('dm_kategoris', 'dkategori_nama_kategori')->ignore($penerbit->id_dkategori, 'id_dkategori'),
                    'regex:/^[a-zA-Z\s]+$/'
                ],
            ];

            $messages = [
                'nama_kategori.required' => 'Nama kategori harus diisi!',
                'nama_kategori.unique' => 'Nama kategori sudah terdaftar!',
                'nama_kategori.regex' => 'Nama kategori hanya boleh berisi huruf!',
            ];

            $validated = $request->validate($rules, $messages);

            $penerbit->dkategori_nama_kategori = $request->nama_kategori;
            $penerbit->save();

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dirubah!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function showKategori($id)
    {
        try {
            $id_penerbit = Crypt::decryptString($id);
            $penerbit = DB::table("dm_kategoris")->where("id_dkategori", $id_penerbit)->select("dkategori_nama_kategori")->first();
            return response()->json($penerbit);
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    public function deleteKategori($id = null)
    {
        $id_dpenerbit = Crypt::decryptString($id);
        $penerbit = dm_kategori::find($id_dpenerbit);
        $penerbit->deleted_at = Carbon::now();
        $penerbit->save();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }

    public function linkExport(Request $request)
    {
        try {
            $link = route('referensi.export');
            return \Response::json(array('link' => $link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exportReferensi(Request $request)
    {
        try {
            return (new PenulisExport)->dataExport($request->all())->download('Rekap Penulis.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function linkPrintout(Request $request)
    {
        try {
            $link = route('referensi.printout');
            return \Response::json(array('link' => $link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function printoutReferensi(Request $request)
    {
        // try {
        //     $penulis = dm_penulis::all();
        //     $pdf = Pdf::loadView('pdf.pdf_referensi', compact('penulis'));
        //     return $pdf->stream('Rekap Penulis.pdf');
        // } catch (\Throwable $th) {
        //     throw $th;
        // }

        try {
            $filename = 'Guru.pdf';

            $style = array(
                'border' => true,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );

            $penulis = DB::table('dm_penulis')->get();

            $html = \View::make('pdf.pdf_referensi', [
                'title' => 'Printout Refensi',
                'penulis' => $penulis,
            ])->render();

            TCPDF::setPrintHeader(false);
            TCPDF::setPrintFooter(false);
            TCPDF::SetPageOrientation('L');
            TCPDF::SetMargins(4, 3, 3, true);

            $code = 'https://tcpdf.org/examples/example_050/';

            TCPDF::AddPage();
            TCPDF::write2DBarcode($code, 'QRCODE,Q', 230, 150, 44, 35, false, 'P');
            TCPDF::writeHTML($html, true, false, true, false, '');

            return TCPDF::Output($filename, 'I');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
