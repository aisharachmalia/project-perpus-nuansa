<!DOCTYPE html>
<html>

<head>
    <title>Selamat Datang di Nuansa Baca!</title>
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

        /* Gaya dasar untuk tombol */
            a.button {
                display: inline-block;
                padding: 12px 24px;
                font-size: 16px;
                font-weight: bold;
                color: #fff;
                text-decoration: none;
                text-align: center;
                background: linear-gradient(45deg, #4CAF50, #3A9F44);
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            /* Hover efek */
            a.button:hover {
                background: linear-gradient(45deg, #3A9F44, #4CAF50);
                transform: translateY(-3px);
                box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
            }

            /* Fokus efek */
            a.button:focus {
                outline: none;
                box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.4);
            }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Selamat Datang di Nuansa Baca!</h1>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $data['dsiswa_nama'] }}</strong>!</p>
            <p>Terima kasih telah bergabung dengan keluarga besar <strong>Nuansa Baca</strong>. Kami sangat senang memiliki Anda sebagai anggota!</p>

            <h3>Detail Keanggotaan Anda</h3>
            <table class="details">
                <tr>
                    <th>Nama Anggota</th>
                    <td>{{ $data['dsiswa_nama'] }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $data['dsiswa_email'] }}</td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>{{ $data['password'] }}</td>
                </tr>
                <tr>
                    <th>NIS</th>
                    <td>{{ $data['dsiswa_nis'] }}</td>
                </tr>
            </table>

            <p>Jangan ragu untuk menjelajahi koleksi buku kami yang beragam. Nikmati pengalaman membaca terbaik!</p>
            <p>Jika Anda tidak merasa melakukan pendaftaran ini, silakan abaikan email ini.</p>
            <p>Untuk melanjutkan, silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:</p>
            <!-- Tombol Verifikasi -->
            @if(isset($data['url']))
            <a href="{{ $data['url'] }}" class="button">Verifikasi Email</a>
        @else
            <p>Link verifikasi tidak tersedia.</p>
        @endif
        </div>

        <div class="footer">
            <p>Salam hangat,<br>Tim Perpustakaan Nuansa Baca</p>
        </div>
    </div>
</body>

</html>
