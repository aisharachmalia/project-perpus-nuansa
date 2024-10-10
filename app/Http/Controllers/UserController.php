<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $users = User::query()->where("deleted_at", null);
            return Datatables::of($users)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm modalShow"  data-id="' . Crypt::encryptString($row->id_usr) . '" data-bs-toggle="modal" data-bs-target="#show">View</a>';
                    if ($row->id_usr > 2) {
                        $btn .= ' | <a href="javascript:void(0)" data-bs-toggle="modal" data-id="' . Crypt::encryptString($row->id_usr) . '" data-bs-target="#edit" class="btn btn-success btn-sm modalEdit">Edit</a> | <a href="javascript:void(0)" data-id="' . Crypt::encryptString($row->id_usr) . '" class="btn btn-danger btn-sm deleteUser">Hapus</a>';
                        return $btn;
                    }
                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('setting.users.index');
    }

    public function detail($id = null)
    {
        $id_usr = Crypt::decryptString($id);
        $data['user'] = User::find($id_usr);
        return response($data);
    }
    public function delete($id = null)
    {
        $id_usr = Crypt::decryptString($id);
        $user = User::find($id_usr);
        $user->deleted_at = now();
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Data User Berhasil Dihapus!.',
        ]);
    }
    public function update($id = null, Request $request)
    {
        $id_usr = Crypt::decryptString($id);
        $user = User::find($id_usr);
        $rules = [
            'nama' => 'required',
            'username' => 'required|unique:users,usr_username,' . $user->id_usr . ',id_usr',
            'email' => 'required|email|unique:users,usr_email,' . $user->id_usr . ',id_usr',
        ];

        $messages = [
            'nama.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'email.required' => 'E-Mail harus diisi.',
            'email.email' => 'Format E-Mail tidak sesuai.',
            'username.unique' => 'Username ini telah terdaftar.',
            'email.unique' => 'E-Mail ini telah terdaftar.',
        ];

        $validated = $request->validate($rules, $messages);

        $user->usr_nama = $request->nama;
        $user->usr_username = $request->username;
        $user->usr_email = $request->email;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
        ]);
    }
}
