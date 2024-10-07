<?php

namespace App\Http\Controllers;

use App\Models\dm_guru;
use App\Models\dm_mapel;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Exports\GuruExport;
// use Barryvdh\DomPDF\Facade\Pdf;
use Elibyy\TCPDF\Facades\TCPDF;

class GuruController extends Controller
{
    public function pageGuru(Request $request)
    {
        if (request()->ajax()) {
            $gr = dm_guru::join('dm_mapels', 'dm_gurus.id_mapel', '=', 'dm_mapels.id_mapel')->where('dm_gurus.deleted_at', '=', null)->select('dm_gurus.*', 'dm_mapels.dmapel_nama_mapel')->get();
            return Datatables::of($gr)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $btn = '<div class="d-flex mr-2">
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dguru) . '" class="btn btn-warning btn-sm modalEdit mr-2" data-bs-toggle="modal" data-bs-target="#edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_dguru) . '" class="btn btn-primary btn-sm modalShow " data-bs-toggle="modal" data-bs-target="#show">
                        <i class="bi bi-eye"></i>
                    </a>
                    |
                    <a href="javascript:void(0)" id="btn-delete" data-id="' . Crypt::encryptString($row->id_dguru) . '" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('data_master.guru.index');
    }

    public function showGuru($id = null)
    {
        $id_dguru = Crypt::decryptString($id);
        $gr = \DB::table('dm_gurus')
            ->join('dm_mapels', 'dm_gurus.id_mapel', '=', 'dm_mapels.id_mapel')
            ->where('dm_gurus.id_dguru', $id_dguru)
            ->select('dm_gurus.*', 'dm_mapels.dmapel_nama_mapel')
            ->first();

        $mpl = \DB::table('dm_mapels')->get();
        $slc = '';
        foreach ($mpl as $mp) {
            $slc .= '<option value="' . $mp->id_mapel . '" ' . ($mp->id_mapel == $gr->id_mapel ? 'selected' : '') . '>' . $mp->dmapel_nama_mapel . '</option>';
        }

        return response()->json(['gr' => $gr, 'slc' => $slc]);
    }

    public function addGuru(Request $request)
    {
        try {
            $rules = [
                'dguru_nama' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
                'dguru_nip' => 'required|unique:dm_gurus,dguru_nip',
                'dguru_email' => 'required|email|unique:dm_gurus,dguru_email',
                'dguru_no_telp' => 'required|unique:dm_gurus,dguru_no_telp|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:13',
                'dguru_alamat' => 'required',
                'id_mapel' => 'required',
            ];

            $messages = [
                'dguru_email.email' => 'Format email tidak sesuai',
                'id_mapel.required' => 'Mata Pelajaran harus diisi!',
                'dguru_nama.required' => 'Nama harus diisi!',
                'dguru_nama.regex' => 'Hanya boleh huruf!',
                'dguru_nama.max' => 'Maksimal 255 karakter!',
                'dguru_nip.required' => 'NIP harus diisi!',
                'dguru_email.required' => 'Email harus diisi!',
                'dguru_no_telp.required' => 'No. Telp harus diisi!',
                'dguru_alamat.required' => 'Alamat harus diisi!',
                'dguru_nip.unique' => 'NIP sudah terdaftar!',
                'dguru_email.unique' => 'Email sudah terdaftar!',
                'dguru_no_telp.unique' => 'No. Telp sudah terdaftar!',
                'dguru_no_telp.regex' => 'No. Telp harus angka!',
                'dguru_no_telp.min' => 'No. Telp minimal 11 angka!',
                'dguru_no_telp.max' => 'No. Telp maksimal 13 angka!',

            ];

            // Lakukan validasi
            $validator = \Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            dm_guru::create([
                'id_mapel' => $request->id_mapel,
                'dguru_nama' => $request->dguru_nama,
                'dguru_nip' => $request->dguru_nip,
                'dguru_email' => $request->dguru_email,
                'dguru_no_telp' => $request->dguru_no_telp,
                'dguru_alamat' => $request->dguru_alamat,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editGuru($id = null, Request $request)
    {
        try {
            $idGr = Crypt::decryptString($id);
            $guru = dm_guru::find($idGr);

            $rules = [
                'dguru_nama' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
                'dguru_nip' => 'required|unique:dm_gurus,dguru_nip,' . $guru->id_dguru . ',id_dguru',
                'dguru_email' => 'required|email|unique:dm_gurus,dguru_email,' . $guru->id_dguru . ',id_dguru',
                'dguru_no_telp' => 'required|unique:dm_gurus,dguru_no_telp,' . $guru->id_dguru . ',id_dguru|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:11,13',
                'dguru_alamat' => 'required',
                'id_mapel' => 'required',
            ];

            $messages = [
                'id_mapel.required' => 'Mata Pelajaran harus diisi!',
                'dguru_nama.required' => 'Nama harus diisi!',
                'dguru_nama.regex' => 'Hanya boleh huruf!',
                'dguru_nama.max' => 'Maksimal 255 karakter!',
                'dguru_nip.required' => 'NIP harus diisi!',
                'dguru_email.required' => 'Email harus diisi!',
                'dguru_no_telp.required' => 'No. Telp harus diisi!',
                'dguru_alamat.required' => 'Alamat harus diisi!',
                'dguru_nip.unique' => 'NIP sudah terdaftar!',
                'dguru_email.unique' => 'Email sudah terdaftar!',
                'dguru_no_telp.unique' => 'No. Telp sudah terdaftar!',
                'dguru_no_telp.regex' => 'No. Telp harus angka!',
                'dguru_no_telp.digits_between' => 'No. Telp harus di antara 11 hingga 13 angka!',
            ];

            // Lakukan validasi
            $validator = \Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }


            // Create the transaction with mapel ID
            dm_guru::where('id_dguru', $idGr)->update([
                'id_mapel' => $request->id_mapel,
                'dguru_nama' => $request->dguru_nama,
                'dguru_nip' => $request->dguru_nip,
                'dguru_email' => $request->dguru_email,
                'dguru_no_telp' => $request->dguru_no_telp,
                'dguru_alamat' => $request->dguru_alamat,
                'dguru_status' => $request->dguru_status,
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!',
            ]);

        } catch (\Throwable $th) {
            // Handle exception
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
            ]);
        }
    }

    public function deleteGuru($id = null)
    {
        $id_dguru = Crypt::decryptString($id);

        $gr = dm_guru::find($id_dguru);
        $gr->deleted_at = Carbon::now();
        $gr->save();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }

    public function linkExportGuru(Request $request)
    {
        try {
            $link = route('export_dm_guru');
            return \Response::json(array('link' => $link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exportGuru(Request $request)
    {
        try {
            return (new GuruExport)->dataExport($request->all())->download('Rekap Guru.xlsx');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function linkPrintoutGuru(Request $request)
    {
        try {
            $link = route('printout_guru');
            return \Response::json(array('link' => $link));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function printoutGuru(Request $request)
    {
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

            $gr = \DB::table('dm_gurus')
                ->join('dm_mapels', 'dm_gurus.id_mapel', '=', 'dm_mapels.id_mapel')
                ->select('dm_gurus.*', 'dm_mapels.dmapel_nama_mapel')
                ->get();

            $html = \View::make('pdf.pdf_guru', [
                'title' => 'Printout Guru',
                'gr' => $gr
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
