<table>
    <tr>
        <th>Judul Buku</th>
        <th>ISBN</th>
        <th>Nama Penulis</th>
        <th>Nama Penerbit</th>
        <th>Tahun Terbit</th>
    </tr>
        <tr>
            <td>{{ $bk[0]->dbuku_judul }}</td>
            <td>'{{ $bk[0]->dbuku_isbn }}</td>
            <td>{{ $bk[0]->dpenulis_nama_penulis }}</td>
            <td>{{ $bk[0]->dpenerbit_nama_penerbit }}</td>
            <td>{{ $bk[0]->dbuku_thn_terbit }}</td>
        </tr>
</table>
<table>
    
</table>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>No Salinan</th>
            <th>Kondisi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salinan as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->dsbuku_no_salinan }}</td>
                <td>{{ $item->dsbuku_kondisi }}</td>
                <td>
                    @if ($item->dsbuku_status == 0)
                        Tersedia
                    @elseif ($item->dsbuku_status == 1)
                        Dipinjam
                    @elseif ($item->dsbuku_status == 2)
                        Reservasi
                    @else
                        Tidak Diketahui
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
