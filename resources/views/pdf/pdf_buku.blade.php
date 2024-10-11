<h1 style="text-align:center">Rekap Buku</h1>

<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; ">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="text-align: center" width="5%">No</th>
            <th width="20%" style="text-align: center;">Judul Buku</th>
            <th style="text-align: center;">ISBN</th>
            <th>Nama Penulis</th>
            <th>Nama Penerbit</th>
            <th style="text-align: center;">Kategori</th>
            <th>Mata Pelajaran</th>
            <th style="text-align: center;">Tahun Terbit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($buku as $key => $item)
            <tr>
                <td style="text-align: center;background-color: #fefe76" width="5%">{{ $key + 1 }}</td>
                <td width="20%">{{ $item->dbuku_judul }}</td>
                <td style="text-align: start;">{{ $item->dbuku_isbn }}</td>
                <td>{{ $item->dpenulis_nama_penulis }}</td>
                <td>{{ $item->dpenerbit_nama_penerbit }}</td>
                <td>{{ $item->dkategori_nama_kategori }}</td>
                <td>{{ $item->dmapel_nama_mapel }}</td>
                <td style="text-align: center;">{{ $item->dbuku_thn_terbit }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
