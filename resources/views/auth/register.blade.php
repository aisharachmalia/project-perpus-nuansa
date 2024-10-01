<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mazer Admin Dashboard</title>
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
                    <h1 class="auth-title">Sign Up</h1>

                    <form method="POST" action="{{ route('post_register_user') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="usr_nama" placeholder="Nama" value="{{ old('usr_nama') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @if ($errors->has('usr_nama'))
                                <span class="text-danger">{{ $errors->first('usr_nama') }}</span>
                            @endif
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="usr_username" placeholder="Username" value="{{ old('usr_username') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            @if ($errors->has('usr_username'))
                                <span class="text-danger">{{ $errors->first('usr_username') }}</span>
                            @endif
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="usr_email" placeholder="Email" value="{{ old('usr_email') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @if ($errors->has('usr_email'))
                                <span class="text-danger">{{ $errors->first('usr_email') }}</span>
                            @endif
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password_konf" placeholder="Confirm Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @if ($errors->has('password_konf'))
                                <span class="text-danger">{{ $errors->first('password_konf') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-2">Sign Up</button>
                    </form>
                    <div class="text-center mt-4 text-lg fs-4">
                        <p class='text-gray-600'>Sudah memiliki akun ? <a href="{{ route('login') }}" class="font-bold">Log in</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
            </div>
        </div>

    </div>
</body>

</html>