<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Mazer Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-3 col-12">
            </div>
            <div class="col-lg-6 col-12">
                <div id="auth-left">
                    <h2 class="auth-title">Reset Password.</h2>
                    <form method="POST" action="{{ route('reset_pass') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="hidden" class="form-control form-control-xl" name="usr_email"
                                placeholder="Username" value="{{ \Crypt::encryptString($user->usr_email) }}"
                                readonly>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="kode_otp"
                                placeholder="Kode OTP">
                            <div class="form-control-icon">
                                <i class="bi bi-lock"></i>
                            </div>
                            @if ($errors->has('kode_otp'))
                                <span class="text-danger">{{ $errors->first('kode_otp') }}</span>
                            @endif
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password"
                                placeholder="New password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password_konf"
                                placeholder="Confirm Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @if ($errors->has('password_konf'))
                                <span class="text-danger">{{ $errors->first('password_konf') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Kirim</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Tidak Memiliki Akun? <a href="{{ route('register') }}"
                                class="font-bold">Sign up</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            text: 'Cek email Anda untuk memverifikasi akun.',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('success_ver'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('success_ver') }}',
            text: 'Silahkan login menggunakan usernama dan Password yang telah didaftarkan.',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('error_login'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ session('error_login') }}',
            text: 'Username atau Password yang anda masukan tidak sesuai.',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@if (session('error_kode_otp'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ session('error_kode_otp') }}',
            text: 'Harap masukan kode otp yang sesuai.',
            confirmButtonText: 'OK'
        });
    </script>
@endif