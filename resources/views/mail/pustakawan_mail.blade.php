<!DOCTYPE html>
<html>

<head>
    <title>Selamat Datang di NuansaBaca!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            text-align: center;
            background-color: #6200ea;
            color: white;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            color: #333;
        }

        .content p {
            margin: 0 0 15px;
            line-height: 1.6;
        }

        .details {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        .details th,
        .details td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .details th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
            padding: 10px 0;
            border-top: 1px solid #ddd;
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
        <div class="header">
            <h1>Selamat Datang di NuansaBaca!</h1>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $data['dpustakawan_nama'] }}</strong>!</p>
            <p>Terima kasih telah bergabung dengan keluarga besar <strong>NuansaBaca</strong>. Kami sangat senang memiliki Anda sebagai Pustakaawan!</p>

            <h3>Detail Pustakaawan Anda</h3>
            <table class="details">
                <tr>
                    <th>Nama Anggota</th>
                    <td>{{ $data['dpustakawan_nama'] }}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $username }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $data['dpustakawan_email'] }}</td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>{{ $password }}</td>
                </tr>
            </table>

            <p>Jangan ragu untuk menjelajahi koleksi buku kami yang beragam. Nikmati pengalaman membaca terbaik!</p>
            <p>Jika Anda tidak merasa melakukan pendaftaran ini, silakan abaikan email ini.</p>

            <p>klik di bawah ini untuk verifikasi email</p>
            <a href="{{ $url }}" class="button">Verifikasi Email</a>
            
        </div>

        <div class="footer">
            <p>Salam hangat,<br>Tim Perpustakaan NuansaBaca</p>
        </div>
    </div>
</body>

</html>
