<table>
    <tr>
        <th>No</th>
        <th>NIP</th>
        <th>Nama</th>
        <th>Email</th>
        <th>No.Telepon</th>
        <th>Alamat</th>
        <th>Mata Pelajaran</th>
    </tr>
    @foreach ($gr as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->dguru_nip }}</td>
            <td>{{ $item->dguru_nama }}</td>
            <td>{{ $item->dguru_email }}</td>
            <td>{{ $item->dguru_no_telp }}</td>
            <td>{{ $item->dguru_alamat }}</td>
            <td>{{ $item->dmapel_nama_mapel }}</td>
        </tr>
    @endforeach
</table>
