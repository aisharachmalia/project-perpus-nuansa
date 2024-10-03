<?php

namespace App\Http\Controllers;

use App\Models\Dm_kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class KelasController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $kelas = Dm_kelas::query()->whereNull('deleted_at')->get(); // Lebih baik menggunakan whereNull
        return Datatables::of($kelas)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = 'View';
                if ($row->id_dkelas > 2) {
                    $btn .= ' | Edit | Hapus';
                }
                return $btn;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d-m-Y');
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return view('dmkelas.index');
}

   public function detail($id)
{
    try {
        $kelas = Dm_kelas::where('id_dkelas', $id)->firstOrFail();
        return response()->json($kelas);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Terjadi kesalahan'], 500);
    }
}

   public function update(Request $request, $id)
{
    // Validasi input
    $validatedData = $request->validate([
        'dkelas_nama_kelas' => 'required|string|max:255',
        'dkelas_tingkat' => 'required|string|max:255',
        'dkelas_jurusan' => 'required|string|max:255',
    ]);

    // Temukan kelas berdasarkan ID
    $kelas = Dm_kelas::find($id);
    if (!$kelas) {
        return response()->json(['message' => 'Kelas tidak ditemukan'], 404);
    }

    // Update data kelas
    $kelas->dkelas_nama_kelas = $validatedData['dkelas_nama_kelas'];
    $kelas->dkelas_tingkat = $validatedData['dkelas_tingkat'];
    $kelas->dkelas_jurusan = $validatedData['dkelas_jurusan'];
    $kelas->save();

    return response()->json(['message' => 'Kelas berhasil diupdate'], 200);
}




    public function destroy($id)
{
    $kelas = Dm_kelas::find($id);

    if ($kelas) {
        $kelas->delete();
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

    return response()->json(['message' => 'Data tidak ditemukan'], 404);
}


}
