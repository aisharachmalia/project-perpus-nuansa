<!DOCTYPE html>
<html>

<head>
    <title>Pengembalian Buku</title>
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
        <h2>Hello, {{ $data['dsiswa_nama'] }}</h2>
        <p>Terima kasih telah mengembalikan buku yang Anda pinjam. Berikut adalah rincian pengembalian buku Anda:</p>

        <div class="row">
            <div class="column">
                <span class="label">Nama Peminjam:</span>
                <span class="value">{{ $data['dsiswa_nama'] }}</span>
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

        <div class="row">
            <div class="column">
                <span class="label">Tanggal Pengembalian:</span>
                <span class="value">{{ $data['trks_tgl_pengembalian'] }}</span>
            </div>
        </div>

        <p>
            @if ($data['trks_denda'] > 0)
                Anda terlambat mengembalikan buku dan dikenakan denda sebesar Rp. {{ $data['trks_denda'] }}. Mohon untuk
                segera melunasi denda tersebut pada saat kunjungan Anda berikutnya ke perpustakaan.
            @else
                Terima kasih telah meminjam buku di perpustakaan SMK Assalaam Bandung. Anda mengembalikan buku tepat
                waktu, tidak ada
                denda yang dikenakan.
            @endif

        </p>

        <p>Salam, <br><br>Perpustakaan SMK</p>
    </div>
</body>

</html>
