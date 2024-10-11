<h1 style="text-align:center; margin-bottom: 20px;"><b>{{ $title }}</b></h1>

<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th width="5%" style="text-align: center;">No</th>
            <th style="text-align: center;">Buku</th>
            <th style="text-align: center;" width="10%">Siswa</th>
            <th style="text-align: center;" width="15%">Tanggal Peminjaman</th>
            <th style="text-align: center;" width="15%">Tanggal Jatuh Tempo</th>
            <th style="text-align: center;" width="15%">Tanggal Pengembalian</th>
            <th style="text-align: center;">Denda</th>
            <th style="text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($trks as $key => $item)
            <tr>
                <td style="text-align: center; background-color: #fefe76;" width="5%">{{ $key + 1 }}</td>
                <td style="text-align: left;">{{ $item->dbuku_judul }}</td>
                <td style="text-align: center;"  width="10%">{{ $item->dsiswa_nama }}</td>
                <td style="text-align: center;"  width="15%">{{ \Carbon\Carbon::parse($item->trks_tgl_peminjaman)->format('d-m-Y') }}</td>
                <td style="text-align: center;"  width="15%">{{ \Carbon\Carbon::parse($item->trks_tgl_jatuh_tempo)->format('d-m-Y') }}</td>
                <td style="text-align: center;"  width="15%">
                    @if($item->trks_tgl_pengembalian)
                        {{ \Carbon\Carbon::parse($item->trks_tgl_pengembalian)->format('d-m-Y') }}
                    @else
                        -
                    @endif
                </td>
                <td style="text-align: center;">{{ number_format($item->tdenda_jumlah, 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    @if($item->tdenda_status == 0)
                        Lunas
                    @elseif($item->tdenda_status == 1)
                        Sudah Dikembalikan
                    @elseif($item->tdenda_status == 2)
                        Dikembalikan
                    @elseif($item->tdenda_status == 3)
                        Dipinjam
                    @elseif($item->tdenda_status == 4)
                        Belum Dikembalikan
                    @else
                        Denda
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
