<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Buku</title>
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
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reservasi Buku Tersedia</h1>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $data['usr_nama'] }}</strong>!</p>
            <p>Reservasi Anda untuk buku dengan judul <strong>{{ $data['dbuku_judul'] }}</strong> sudah tersedia.</p>

            <h3>Detail Reservasi</h3>
            <table class="details">
                <tr>
                    <th>Judul Buku</th>
                    <td>{{ $data['dbuku_judul'] }}</td>
                </tr>
                <tr>
                    <th>Tanggal Reservasi</th>
                    <td>{{ $data['trsv_tgl_reservasi'] }}</td>
                </tr>
                <tr>
                    <th>Tanggal Kadaluarsa</th>
                    <td>{{ $data['trsv_tgl_kadaluarsa'] }}</td>
                </tr>
            </table>

            <p>Silakan datang ke perpustakaan untuk mengambil buku Anda.</p>
            <p>Terima kasih telah menggunakan layanan reservasi kami!</p>
        </div>

        <div class="footer">
            <p>Salam hangat,<br>Tim Perpustakaan Nuansa Baca</p>
        </div>
    </div>
</body>

</html>