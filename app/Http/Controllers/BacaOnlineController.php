<?php

namespace App\Http\Controllers;

use App\Models\baca_online;
use App\Models\dm_buku;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BacaOnlineController extends Controller
{
    public function documentDetail($id = null)
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

        return view(
            'data_master.buku.baca_online',
            ['bk' => $bk[0],]
        );
    }


    public function startReading(Request $request, $id)
    {
        try {

            if (!\Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda harus login terlebih dahulu.',
                ], 401);
            }
            // Dekripsi ID buku
            $id_dbuku = \Crypt::decryptString($id);

            // Pastikan ID adalah integer
            if (!is_numeric($id_dbuku)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ID buku tidak valid.',
                ], 400);
            }

            // Cek apakah sudah ada entri di baca_online
            $bacaOnline = baca_online::where('id_dbuku', $id_dbuku)
                ->where('id_usr', \Auth::id())
                ->first();

            if (!$bacaOnline) {
                // Buat entri baru
                $bacaOnline = baca_online::create([
                    'id_dbuku' => $id_dbuku,
                    'id_usr' => \Auth::id(),
                    'tgl_mulai_baca' => now("Asia/Jakarta"),
                    'status_baca' => 1,
                ]);
            } else {
                // Perbarui entri yang sudah ada
                $bacaOnline->update([
                    'tgl_mulai_baca' => now("Asia/Jakarta"),
                    'status_baca' => 1,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Anda telah mulai membaca.',
                'baca_online' => $bacaOnline,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in startReading: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memulai membaca buku.',
            ], 500);
        }
    }

    public function finishReading(Request $request, $id)
    {
        try {
            if (!\Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda harus login terlebih dahulu.',
                ], 401);
            }

            // Dekripsi ID buku
            $id_dbuku = \Crypt::decryptString($id);

            // Pastikan ID adalah integer
            if (!is_numeric($id_dbuku)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ID buku tidak valid.',
                ], 400);
            }

            // Cari entri baca_online berdasarkan id_dbuku dan id_usr
            $bacaOnline = baca_online::where('id_dbuku', $id_dbuku)
                ->where('id_usr', \Auth::id())
                ->first();

            if ($bacaOnline) {
                // Update status baca menjadi selesai dan isi tgl_selesai_baca
                $bacaOnline->update([
                    'status_baca' => 2,  // Status selesai baca
                    'tgl_selesai_baca' => now(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Buku berhasil selesai dibaca.',
                    'baca_online' => $bacaOnline,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan.',
                ], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Error in finishReading: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyelesaikan membaca buku.',
            ], 500);
        }
    }

    public function historyBaca(Request $request)
    {
        try {
            if (!\Auth::check()) {
                return redirect()->route('login-usr')->with('error', 'Anda harus login terlebih dahulu.');
            }
            $bacaOnline = baca_online::where('id_usr', \Auth::id())->get();

            
            foreach ($bacaOnline as $book) {
                if (\Storage::exists('public/cover/' . $book->dbuku_cover)) {
                    // If the file exists, generate a URL to 'storage/cover/'
                    $book->dbuku_cover = asset('storage/cover/' . $book->dbuku_cover);
                } else {
                    // If the file does not exist, use the default image path
                    $book->dbuku_cover = asset('assets/images/buku/default.jpg');
                }
            }

            return view("history", compact('bacaOnline'));

        } catch (\Exception $e) {
            \Log::error('Error in finishReading: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyelesaikan membaca buku.');
        }
    }
}
