@extends('master')

@section('content')
    @php
        $role = App\Models\Akses_usr::join('users', 'akses_usrs.id_usr', 'users.id_usr')
            ->where('users.id_usr', Auth::User()->id_usr)
            ->join('roles', 'akses_usrs.id_role', 'roles.id_role')
            ->first();

        $user = App\Models\User::find(Auth::User()->id_usr);
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
                                        <h4 class="pt-sm-2 pb-1 mb-0 text-start p-1">{{ Auth::User()->usr_username }}
                                        </h4>
                                        <p class="mb-0 text-start p-1">{{ Auth::User()->usr_email }}</p>
                                        {{-- <form action="{{ route('update_profile_image') }}" method="POST" enctype="multipart/form-data">
                                            <input type="file" name="file" id="file">
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </form> --}}
                                    </div>
                                    <div class="text-center text-sm-right">
                                        <span class="badge badge-secondary">Ad</span>
                                        <div class="text-muted"><small>Bergabung
                                                {{ Auth::User()->created_at->format('d. M. Y') }}</small></div>
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
                                                        <td>{{ Auth::User()->created_at->format('d/m/Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Terakhir Lihat:
                                                        </td>
                                                        <td>
                                                            {{-- @if (Auth::User()->last_active_at)
                                                                    
                                                                        {{ Auth::User()->last_active_at}}
                                                                    
                                                                @else
                                                                    --
                                                                @endif --}}
                                                            ---
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email:</td>
                                                        <td>
                                                            @if (Auth::User()->email_verified)
                                                                Terverifikasi
                                                            @else
                                                                Belum Terverifikasi
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Role:</td>
                                                        <td>{{ Auth::User()->usr_nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status:</td>
                                                        <td>
                                                            @if (Auth::User()->usr_stat == 1)
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
                                                                value="{{ Auth::User()->usr_nama }}">
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
                                                                value="{{ Auth::User()->usr_username }}">
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
                                                                value="{{ Auth::User()->usr_email }}">
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
                                                <div class="form-group">
                                                    <label>
                                                        <p><b> Ubah Password</b></p>
                                                        <input type="checkbox" class="form-check-input"
                                                            id="toggleCheckbox">&nbsp;<span class="text-danger">*</span>klik
                                                        jika anda ingin memperbahui password
                                                    </label>
                                                </div>

                                                <div class="form-group">
                                                    <label>Password Lama</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="password_lama"
                                                            id="password_lama" placeholder="Masukkan password lama"
                                                            disabled>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="togglePasswordVisibility('password_lama', 'password_lama_icon')">
                                                            <i id="password_lama_icon" class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                    @if ($errors->has('password_lama'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('password_lama') }}</span>
                                                    @endif
                                                </div>

                                                <!-- Input untuk Password -->
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="password"
                                                            placeholder="masukkan password" id="passwordField" disabled>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="togglePasswordVisibility('passwordField', 'togglePasswordIcon')">
                                                            <i id="togglePasswordIcon" class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>

                                                <!-- Input untuk Konfirmasi Password -->
                                                <div class="form-group">
                                                    <label>Konfirmasi Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="password_konf"
                                                            placeholder="konfirmasi password" id="passwordConfirmField"
                                                            disabled>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="togglePasswordVisibility('passwordConfirmField', 'togglePasswordConfirmIcon')">
                                                            <i id="togglePasswordConfirmIcon" class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                    @if ($errors->has('password_konf'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('password_konf') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col d-flex justify-content-end">
                                                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
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

    <script>
        document.getElementById('toggleCheckbox').addEventListener('change', function() {
            // Get references to the password fields
            const passwordField = document.getElementById('passwordField');
            const password_lama = document.getElementById('password_lama');
            const passwordConfirmField = document.getElementById('passwordConfirmField');

            // Toggle the disabled property based on checkbox status
            const isEnabled = this.checked;
            passwordField.disabled = !isEnabled;
            password_lama.disabled = !isEnabled;
            passwordConfirmField.disabled = !isEnabled;
        });

        function togglePasswordVisibility(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>
@endsection
