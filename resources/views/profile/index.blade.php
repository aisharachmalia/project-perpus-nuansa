@extends('master')

@section('content')
    @php
        $role = App\Models\akses_usr::join('users', 'akses_usrs.id_usr', 'users.id_usr')
            ->where('users.id_usr', Auth::user()->id_usr)
            ->join('roles', 'akses_usrs.id_role', 'roles.id_role')
            ->first();

        $user = App\Models\User::find(Auth::user()->id_usr);
    @endphp
    <link rel="stylesheet" href="{{ asset('assets/css/pages/profile.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="row">
            <div class="col mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="e-profile">
                            <div class="row">
                                <div class="col-12 col-sm-auto mb-3">
                                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->usr_nama) . '&size=128&background=0D8ABC&color=fff&bold=true' }}"
                                        alt="Profile Image" class="rounded-circle" width="150">
                                </div>
                                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                                        <h4 class="pt-sm-2 pb-1 mb-0 text-start p-1">{{ Auth::user()->usr_username }}
                                        </h4>
                                        <p class="mb-0 text-start p-1">{{ Auth::user()->usr_email }}</p>
                                        {{-- <form action="{{ route('update_profile_image') }}" method="POST" enctype="multipart/form-data">
                                            <input type="file" name="file" id="file">
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </form> --}}
                                    </div>
                                    <div class="text-center text-sm-right">
                                        <span class="badge badge-secondary">Ad</span>
                                        <div class="text-muted"><small>Bergabung
                                                {{ Auth::user()->created_at->format('d. M. Y') }}</small></div>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-tabs mt-3">
                                <li class="nav-item">
                                    <a href="#profile-tab" class="nav-link {{ $errors->isEmpty() ? 'active' : '' }}"
                                        data-bs-toggle="tab">Profile</a>
                                </li>
                                @if ($role && !in_array($role->id_role, [1, 2]))
                                    <!-- Assuming 1 and 2 are Admin/Superuser roles -->
                                    <li class="nav-item">
                                        <a href="#settings-tab" class="nav-link {{ $errors->isNotEmpty() ? 'active' : '' }}"
                                            data-bs-toggle="tab">Setting</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content pt-3">
                                <!-- Profile Tab -->
                                <div class="tab-pane {{ $errors->isEmpty() ? 'active' : '' }}" id="profile-tab">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <table class="table user-view-table m-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Bergabung:</td>
                                                        <td>{{ Auth::user()->created_at->format('d/m/Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Terakhir Lihat:
                                                        </td>
                                                        <td>
                                                            {{-- @if (Auth::user()->last_active_at)
                                                                    
                                                                        {{ Auth::user()->last_active_at}}
                                                                    
                                                                @else
                                                                    --
                                                                @endif --}}
                                                            ---
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email:</td>
                                                        <td>
                                                            @if (Auth::user()->email_verified)
                                                                Terverifikasi
                                                            @else
                                                                Belum Terverifikasi
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Role:</td>
                                                        <td>{{ Auth::user()->usr_nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status:</td>
                                                        <td>
                                                            @if (Auth::user()->usr_stat == 1)
                                                                Aktif
                                                            @else
                                                                Tidak Aktif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings Tab -->
                                <div class="tab-pane {{ $errors->isNotEmpty() ? 'active' : '' }}" id="settings-tab">
                                    <form class="form" method="POST" action="{{ route('update_profile') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Nama</label>
                                                            <input class="form-control" type="text" name="usr_nama"
                                                                value="{{ Auth::user()->usr_nama }}">
                                                            @if ($errors->has('usr_nama'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('usr_nama') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Username</label>
                                                            <input class="form-control" type="text" name="usr_username"
                                                                value="{{ Auth::user()->usr_username }}">
                                                            @if ($errors->has('usr_username'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('usr_username') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input class="form-control" type="email" name="usr_email"
                                                                value="{{ Auth::user()->usr_email }}">
                                                            @if ($errors->has('usr_email'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('usr_email') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row mt-4">
                                            <div class="col">
                                                <p><b> Ubah Password</b></p>
                                                <div class="form-group">
                                                    <label>password</label>
                                                    <input class="form-control" type="password" name="password"
                                                        placeholder="masukkan password">
                                                    @if ($errors->has('password'))
                                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>konfirmasi password</label>
                                                    <input class="form-control" type="password" name="password_konf"
                                                        placeholder="konfirmasi password">
                                                    @if ($errors->has('password_konf'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('password_konf') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col d-flex justify-content-end">
                                                <button class="btn btn-primary" type="submit">Simpan Pembaruan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@endsection
