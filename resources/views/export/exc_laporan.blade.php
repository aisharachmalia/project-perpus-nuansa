<table>
    <tr>
        <th colspan="8" style="text-align: center; color: blue">Rekap Laporan Transaksi</th>
    </tr>
</table>
<table border="1">
    <tr>
        <th style="text-align: center">No</th>
        <th>Buku</th>
        <th>Siswa</th>
        <th>Tanggal Peminjaman</th>
        <th>Tangal Jatuh Tempo</th>
        <th>Tanggal Pengembalian</th>
        <th>Denda</th>
        <th>Status</th>
    </tr>
    @foreach ($trks as $key => $item)
        <tr>
            <td style="text-align: center">{{ $key + 1 }}</td>
            <td>{{ $item->dbuku_judul }}</td>
            <td>{{ $item->usr_nama }}</td>
            <td style="text-align: center;">
                {{ \Carbon\Carbon::parse($item->trks_tgl_peminjaman)->format('d-m-Y H:i') }}</td>
            <td style="text-align: center;">
                {{ \Carbon\Carbon::parse($item->trks_tgl_jatuh_tempo)->format('d-m-Y H:i') }}</td>
            <td style="text-align: center;">
                @if ($item->trks_tgl_pengembalian)
                    {{ \Carbon\Carbon::parse($item->trks_tgl_pengembalian)->format('d-m-Y H:i') }}
                @else
                    -
                @endif
            </td>
            <td>Rp.@if ($item->jumlah == null)
                    0
                @else
                    {{ $item->jumlah }}
                @endif
            </td>
            <td style="text-align: center;">
                @if ($item->trks_status == 1)
                    Dipinjam
                @elseif($item->trks_status == 2)
                    Dikembalikan
                @else
                    Belum Dikembalikan
                @endif
            </td>
        </tr>
    @endforeach
</table>
