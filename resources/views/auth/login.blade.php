<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan-Halaman Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-3 col-12">
            </div>
            <div class="col-lg-6 col-12">
                <div id="auth-left">
                    <h2 class="auth-title">Log in.</h2>
                    <form method="POST" action="{{ route('login_user') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="usr_username"
                                placeholder="Username"
                                @if (isset($login_user)) @if ($login_user != null) value="{{ $login_user[0] }}" @endif
                                @endif>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @if ($errors->has('usr_username'))
                                <span class="text-danger">{{ $errors->first('usr_username') }}</span>
                            @endif
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password" id="password"
                                placeholder="Password"
                                @if (isset($login_user)) @if ($login_user != null) value="{{ $login_user[1] }}" @endif
                                @endif>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-5"
                                onclick="togglePassword()" style="cursor: pointer;">
                                <div class="form-control-icon">
                                    <i id="toggleIcon" class="bi bi-eye"></i>
                                </div>
                            </span>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" name="remember_me"
                                value="{{ \Crypt::encryptString(1) }}"
                                @if (isset($login_user)) @if ($login_user != null) checked @endif
                                @endif>
                            <label class="form-check-label text-gray-600" for="flexCheckDefault" name="remember">
                                Ingat saya
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Tidak Memiliki Akun? <a href="{{ route('register') }}"
                                class="font-bold">Sign up</a>.</p>
                        <p><a class="font-bold" href="{{ route('forgot_password') }}">Lupa Password?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
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
@if (session('error_login2'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ session('error_login2') }}',
            text: 'Akun ada belum terverifikasi.',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@if (session('error_login3'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ session('error_login3') }}',
            text: 'Akun yang anda masukkan tidak ada.',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@if (session('success_ganti_password'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('success_ganti_password') }}',
            text: 'Anda berhasil mengubah password anda.',
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
@if (session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }
</script>
