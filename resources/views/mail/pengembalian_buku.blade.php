<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Buku Tersedia</title>
</head>
<body>
    <h2>Halo, {{ $data['usr_nama'] }}</h2>

    <p>Reservasi Anda untuk buku dengan judul <strong>{{ $data['dbuku_judul'] }}</strong> sudah tersedia.</p>

    <p><strong>Detail Reservasi:</strong></p>
    <ul>
        <li>Judul Buku: {{ $data['dbuku_judul'] }}</li>
        <li>Tanggal Reservasi: {{ $data['trsv_tgl_reservasi'] }}</li>
    </ul>

    <p>Silakan datang ke perpustakaan untuk mengambil buku Anda.</p>

    <p>Terima kasih telah menggunakan layanan reservasi kami!</p>

    <p>Salam,</p>
    <p><strong>Perpustakaan SMK</strong></p>
</body>
</html>
