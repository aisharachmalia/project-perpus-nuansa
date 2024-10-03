<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIS</th>
        <th>Email</th>
        <th>No Telp</th>
        <th>Alamat</th>
        <th>Kelas</th>
    </tr>
    @foreach ($siswa as $key => $item)
    <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $item->dsiswa_nama}}</td>
        <td>{{ $item->dsiswa_nis}}</td>
        <td>{{ $item->dsiswa_email}}</td>
        <td>{{ $item->dsiswa_no_telp}}</td>
        <td>{{ $item->dsiswa_alamat}}</td>
        <td>{{ $item->dkelas_nama_kelas}}</td>
    </tr>
    @endforeach
</table>