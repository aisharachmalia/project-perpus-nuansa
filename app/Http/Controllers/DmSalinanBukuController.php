<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dm_salinan_buku;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BukuSalinanExport;

class DmSalinanBukuController extends Controller
{
    public function pageDmSalinanBuku($id = null, Request $request)
    {
        $id = \Crypt::decryptString($id);
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

        return view('data_master.buku.dm_salinan', [
            'id' => $id,
            'bk' => $bk[0],
        ]);
    }

    public function tableDmSalinanBuku(Request $request)
    {
        $id = \Crypt::decryptString($request->id);
        if ($request->ajax()) {
            $salinanBukus = \DB::select(
                "SELECT * FROM dm_salinan_bukus 
                                    join dm_buku on dm_salinan_bukus.id_dbuku = dm_buku.id_dbuku
                                    WHERE dm_buku.id_dbuku = $id AND dm_salinan_bukus.deleted_at IS NULL;"
            );


            // Return the data for DataTables
            return DataTables::of($salinanBukus)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // Start the action button HTML with the edit button
                    $btn = '<div class="d-flex mr-2 justify-content-center">
                            <a href="javascript:void(0)" data-id="' . \Crypt::encryptString($row->id_dsbuku) . '" class="btn btn-warning btn-sm modalEditSalinan mr-2" data-bs-toggle="modal" data-bs-target="#editSalinan">
                                <i class="bi bi-pencil"></i>
                            </a>';

                    // Add delete button only if the condition is not "Hilang"
                    if ($row->dsbuku_kondisi !== 'Hilang') {
                        $btn .= ' |
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . \Crypt::encryptString($row->id_dsbuku) . '" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>';
                    }

                    $btn .= '</div>';

                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function salinanDetail($id = null)
    {
        $id = \Crypt::decryptString($id);
        $dsbk = \DB::select("SELECT dm_salinan_bukus.* FROM dm_salinan_bukus 
                                    WHERE dm_salinan_bukus.id_dsbuku = $id
                            ");
        $kondisi = [
            'Baik' => 'Baik',
            'Rusak' => 'Rusak',
            'Hilang' => 'Hilang',
        ];

        $selectedKondisi = $dsbk[0]->dsbuku_kondisi ?? '';

        $radioButtons = '';
        foreach ($kondisi as $kds) {
            $checked = ($kds == $selectedKondisi) ? 'checked' : ''; // Jika kondisi sebelumnya cocok, tambahkan atribut checked
            $radioButtons .= '<label><input type="radio" name="dsbuku_kondisi" value="' . $kds . '" ' . $checked . '> ' . $kds . '</label>&nbsp;';
        }

        return response()->json([
            'dsbk' => $dsbk,
            'radioButtons' => $radioButtons
        ]);
    }

    public function crudSalinanBuku($id = null, Request $request)
    {
        try {

            if ($request->isMethod('post') && $id) {
                try {
                    $id_dsbk = \Crypt::decryptString($id);
                    $ids = dm_salinan_buku::where('id_dsbuku', $id_dsbk)->first();

                    if ($ids->dsbuku_status == 1 || $ids->dsbuku_status == 2) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Data ini tidak bisa diubah!'
                        ], 422);
                    } else {
                        $rules = [
                            'dsbuku_no_salinan' => 'required|unique:dm_salinan_bukus,dsbuku_no_salinan,' . $id_dsbk . ',id_dsbuku',
                            'dsbuku_kondisi' => 'required',
                        ];

                        $messages = [
                            'dsbuku_no_salinan.required' => 'No. Salinan harus diisi!',
                            'dsbuku_no_salinan.unique' => 'No. Salinan sudah terdaftar!',
                            'dsbuku_kondisi.required' => 'Kondisi harus diisi!',
                        ];

                        // Lakukan validasi
                        $validator = \Validator::make($request->all(), $rules, $messages);

                        if ($validator->fails()) {
                            return response()->json([
                                'success' => false,
                                'errors' => $validator->errors()
                            ], 422);
                        }

                        $kondisiSebelumnya = $ids->dsbuku_kondisi;

                        // Update data ids buku
                        $ids->update([
                            'dsbuku_no_ids' => $request->dsbuku_no_ids,
                            'dsbuku_kondisi' => $request->dsbuku_kondisi,
                            'dsbuku_status' => $ids->dsbuku_status,
                            'updated_at' => now(),
                        ]);

                        // Hanya update jumlah buku jika kondisi berubah
                        if ($kondisiSebelumnya != $request->dsbuku_kondisi) {
                            if ($request->dsbuku_kondisi == 'Hilang') {
                                \DB::table('dm_buku')
                                    ->where('id_dbuku', $ids->id_dbuku)
                                    ->decrement('dbuku_jml_total');
                            } elseif ($kondisiSebelumnya == 'Hilang' && $request->dsbuku_kondisi == 'Baik') {
                                \DB::table('dm_buku')
                                    ->where('id_dbuku', $ids->id_dbuku)
                                    ->increment('dbuku_jml_total');
                            }
                        }


                        return response()->json([
                            'success' => true,
                            'message' => 'Salinan Buku Berhasil Diubah!',
                        ]);
                    }
                } catch (\Throwable $th) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan!',
                        'error' => $th->getMessage(),
                    ], 500);
                }
            } else if ($request->isMethod('delete')) {
                try {
                    // Decrypt the salinan ID
                    $idsb = \Crypt::decryptString($id);

                    // Find the salinan entry
                    $salinan = dm_salinan_buku::where('id_dsbuku', $idsb)->first();


                    if ($salinan) {
                        if ($salinan->dsbuku_flag == 1 || $salinan->dsbuku_status == 1 || $salinan->dsbuku_status == 2) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Salinan Buku tidak bisa dihapus Karena Buku sedang di pinjam atau sedang direservasi!',
                            ], 403); // Forbidden
                        } else {
                            $salinan->deleted_at = Carbon::now();
                            $salinan->save();

                            // Decrease the total book count in dm_buku
                            \DB::table('dm_buku')
                                ->where('id_dbuku', $salinan->id_dbuku)
                                ->decrement('dbuku_jml_total');

                            // Optionally, update the available count if necessary
                            \DB::table('dm_buku')
                                ->where('id_dbuku', $salinan->id_dbuku)
                                ->decrement('dbuku_jml_tersedia');

                            return response()->json([
                                'success' => true,
                                'message' => 'Salinan Buku Berhasil Dihapus!',
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Salinan Buku tidak ditemukan!',
                        ], 404);
                    }
                } catch (\Throwable $th) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan!',
                        'error' => $th->getMessage(),
                    ], 500);
                }
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // Link generation method
    public function linkExportBuku(Request $request)
    {
        try {
            // Ensure that the ID is provided
            $request->validate(['id' => 'required|integer']);
            $link = route('export_salinan_buku', ['id' => $request->input('id')]);
            return response()->json(['link' => $link]);
        } catch (\Throwable $th) {
            \Log::error('Error in linkExportBuku: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to generate export link'], 500);
        }
    }

    public function exportBuku(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        try {
            $id = $request->id;

            // Create a new instance of the export class, passing in the ID
            return (new BukuSalinanExport($id))->download('Rekap Salinan Buku.xlsx');
        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to export data'], 500);
        }
    }

    public function linkPrintoutBuku(Request $request)
    {
        try {
            // Ensure that the ID is provided
            $request->validate(['id' => 'required|integer']);
            $link = route('printout_salinan_buku', ['id' => $request->input('id')]);
            return response()->json(['link' => $link]);
        } catch (\Throwable $th) {
            \Log::error('Error in linkPrintoutBuku: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to generate printout link'], 500);
        }
    }

    public function printoutBuku(Request $request)
    {
        try {
            // Validate that the ID is present
            $request->validate(['id' => 'required|integer']);
            $id = $request->input('id');

            // Fetch the data using Eloquent
            $salinan = dm_salinan_buku::where('id_dbuku', $id)->get();

            // Ensure that there's data to pass to the view
            if ($salinan->isEmpty()) {
                return response()->json(['error' => 'No data found for the given ID'], 404);
            }

            $html = \View::make('pdf.pdf_salinan_buku', [
                'title' => 'Rekap Data Salinan Buku',
                'salinan' => $salinan
            ])->render();

            // TCPDF generation
            TCPDF::setPrintHeader(false);
            TCPDF::setPrintFooter(false);
            TCPDF::SetPageOrientation('P');
            TCPDF::AddPage();
            TCPDF::writeHTML($html, true, false, true, false, '');

            // Output the PDF to the browser
            return TCPDF::Output('Salinan Buku.pdf', 'I');

        } catch (\Throwable $th) {
            \Log::error('Error in printoutBuku: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to generate printout'], 500);
        }
    }
}
