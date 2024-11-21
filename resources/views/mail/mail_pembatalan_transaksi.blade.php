<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembatalan @if ($data['type'] === 'peminjaman')
            Peminjaman
        @else
            Reservasi
        @endif
    </title>
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
            <h1>Pembatalan @if ($data['type'] === 'peminjaman')
                    Peminjaman
                @else
                    Reservasi
                @endif
            </h1>
        </div>

        <div class="content">
            @if ($data['type'] === 'peminjaman')
                <p>Halo, <strong>{{ $data['usr_nama'] }}</strong>!</p>
                <p>Kami ingin memberitahukan Anda bahwa peminjaman buku Anda telah dibatalkan. Berikut adalah detail
                    peminjaman Anda:</p>
            @else
                <p>Halo, <strong>{{ $data['usr_nama'] }}</strong>!</p>
                <p>Reservasi buku yang Anda ajukan telah dibatalkan. Berikut adalah detail reservasi Anda:</p>
            @endif

            <h3>Detail @if ($data['type'] === 'peminjaman')
                    Peminjaman
                @else
                    Reservasi
                @endif
            </h3>
            <table class="details">
                @if ($data['type'] === 'peminjaman')
                    <tr>
                        <th>Nama Peminjam</th>
                        <td>{{ $data['usr_nama'] }}</td>
                    </tr>
                    <tr>
                        <th>Judul Buku</th>
                        <td>{{ $data['dbuku_judul'] }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Peminjaman</th>
                        <td>{{ $data['trks_tgl_peminjaman'] }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Jatuh Tempo</th>
                        <td>{{ $data['trks_tgl_jatuh_tempo'] }}</td>
                    </tr>
                @else
                    <tr>
                        <th>Nama Peminjam</th>
                        <td>{{ $data['usr_nama'] }}</td>
                    </tr>
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
                @endif
            </table>

            <p>Jika Anda merasa tidak melakukan pembatalan
                @if ($data['type'] === 'peminjaman')
                    peminjaman
                @else
                    reservasi
                @endif,
                buku ini silakan hubungi Perpustakaan Nuansa Baca atau konfirmasikan pembatalan ini kepada petugas.
            </p>

            <p>Terima kasih telah melakukan
                @if ($data['type'] === 'peminjaman')
                    peminjaman
                @else
                    reservasi
                @endif
                di Perpustakaan Nuansa Baca.
            </p>
        </div>

        <div class="footer">
            <p>Salam hangat,<br>Tim Perpustakaan Sekolah</p>
        </div>
    </div>
</body>

</html>
