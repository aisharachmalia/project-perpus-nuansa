<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
            <h1>Reset Password Anda</h1>
            <p>Halo, {{ $data['usr_nama']}}</p>
            <p>Password Anda telah di-reset. Berikut adalah password baru Anda:</p>
            <p><strong>Password: {{ $data['usr_password'] }}</strong></p>
            <p>Jangan lupa untuk segera mengganti password Anda setelah login.</p>
    </div>
</body>
</html>
