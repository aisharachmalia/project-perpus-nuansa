<!DOCTYPE html>
<html>

<head>
    <title>Selamat Datang di Nuansa Baca! {{ $data['usr_nama'] }} </title>
    <style>
        .container {
            width: 100%;
            padding: 20px;
        }

        .row {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .column {
            flex: 1;
            padding: 10px;
        }

        .label {
            font-weight: bold;
        }

        .value {
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <h1>Halo, {{ $data['usr_nama'] }}!</h1>
    <p>Akun Anda telah berhasil dibuat di Perpustakaan SMK. Berikut adalah informasi login Anda:</p>
    <p><strong>Username:</strong> {{ $data['usr_username'] }}</p>
    <p><strong>Password:</strong> {{ $data['password'] }}</p>
    <p>Silakan login dan segera ganti password Anda untuk keamanan lebih lanjut.</p>
    <p>Salam, <br> Perpustakaan SMK</p>
</body>

</html>
