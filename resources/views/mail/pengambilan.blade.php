<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pengambilan Buku</title>
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
            <h1>Konfirmasi Pengambilan Buku</h1>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $data['usr_nama'] }}</strong>!</p>
            <p>Terima kasih telah mengambil buku yang Anda reservasi. Kami harap buku ini dapat membantu dan memberikan manfaat untuk Anda.</p>
            <p>Berikut adalah detail pengambilan buku Anda:</p>

            <h3>Detail Pengambilan</h3>
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
                    <th>Tanggal Pengambilan</th>
                    <td>{{ $data['trsv_tgl_pengambilan'] }}</td>
                </tr>
                <tr>
                    <th>Tanggal Jatuh Tempo</th>
                    <td>{{ $data['trsv_tgl_jatuh_tempo'] }}</td>
                </tr>
            </table>

            <p>Pastikan untuk mengembalikan buku sebelum tanggal jatuh tempo yang tertera. Jika Anda membutuhkan perpanjangan waktu, silakan hubungi petugas perpustakaan.</p>
            <p>Terima kasih telah menggunakan layanan reservasi kami!</p>
        </div>

        <div class="footer">
            <p>Salam hangat,<br>Tim Perpustakaan Sekolah</p>
        </div>
    </div>

</body>

</html>
