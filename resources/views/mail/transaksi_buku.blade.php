<!DOCTYPE html>
<html>

<head>
    <title>Peminjaman Buku</title>
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
    <div class="container">
        <h2>Hello, {{ $data['usr_nama'] }}</h2>
        <p>Berikut adalah rincian peminjaman buku Anda:</p>

        <div class="row">
            <div class="column">
                <span class="label">Nama Peminjam:</span>
                <span class="value">{{ $data['usr_nama'] }}</span>
            </div>
            <div class="column">
                <span class="label">Judul Buku:</span>
                <span class="value">{{ $data['dbuku_judul'] }}</span>
            </div>
        </div>

        <div class="row">
            <div class="column">
                <span class="label">Tanggal Peminjaman:</span>
                <span class="value">{{ $data['trks_tgl_peminjaman'] }}</span>
            </div>
            <div class="column">
                <span class="label">Tanggal Jatuh Tempo:</span>
                <span class="value">{{ $data['trks_tgl_jatuh_tempo'] }}</span>
            </div>
        </div>

        <p>Jika Anda tidak melakukan transaksi ini, Anda bisa mengabaikan email ini.</p>
        <p>Salam, <br><br>Perpustakaan SMK</p>
    </div>
</body>

</html>
