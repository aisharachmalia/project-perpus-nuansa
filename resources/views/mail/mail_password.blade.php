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
        <h1>Reset Password Email Anda</h1>
        <h1>Hello, {{ $data['usr_nama'] }}</h1>
        <p>Password Email : {{$data['usr_password']}}</p>
        <p>Jika Anda tidak membuat akun ini, Anda bisa mengabaikan email ini.</p>
        <p>Salam, <br><br> Project PKL Assalaam</p>
    </div>
</body>
</html>
