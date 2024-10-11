<table>
    <tr>
        <th colspan="8" style="text-align: center; color: blue">Rekap Buku</th>
    </tr>
</table>
<table border="1">
    <tr>
        <th>No</th>
        <th>Judul Buku</th>
        <th>ISBN</th>
        <th>Nama Penulis</th>
        <th>Nama Penerbit</th>
        <th>Kategori</th>
        <th>Mata Pelajaran</th>
        <th>Tahun Terbit</th>
    </tr>
    @foreach ($buku as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item->dbuku_judul }}</td>
            <td>{{ $item->dbuku_isbn }}</td>
            <td>{{ $item->dpenulis_nama_penulis }}</td>
            <td>{{ $item->dpenerbit_nama_penerbit }}</td>
            <td>{{ $item->dkategori_nama_kategori }}</td>
            <td>{{ $item->dmapel_nama_mapel }}</td>
            <td>{{ $item->dbuku_thn_terbit }}</td>
        </tr>
    @endforeach
</table>