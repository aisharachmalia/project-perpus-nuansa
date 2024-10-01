<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Mazer Admin Dashboard</title>
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
                    <h3 class="auth-title">Lupa Password.</h3>
                    @if (session('success_reset'))
                    <div class="alert alert-success">
                        {{ session('success_reset') }}
                    </div>
                @endif
            
                @if (session('error_email'))
                    <div class="alert alert-danger">
                        {{ session('error_email') }}
                    </div>
                @endif
                    <form action="{{ route('lupa_pass') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="usr_email" placeholder="E-Mail">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @if ($errors->has('usr_email'))
                            <span class="text-danger">{{$errors->first('usr_email')}}</span>     
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Kirim</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Tidak Memiliki Akun? <a href="{{ route('register') }}" class="font-bold">Sign up</a>.</p>
                        <p class="text-gray-600">Sudah Memiliki Akun ? <a class="font-bold" href="{{ route('login') }}">Login</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
            </div>
        </div>

    </div>
    
</body>

</html>