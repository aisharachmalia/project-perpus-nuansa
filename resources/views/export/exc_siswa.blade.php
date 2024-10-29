<table style="border-collapse: collapse; width: 100%;">
    <tr>
        <th style="border: 3px solid black; padding: 8px; white-space: nowrap;">No</th>
        <th style="border: 3px solid black; padding: 8px; white-space: nowrap;">Nama</th>
        <th style="border: 3px solid black; padding: 8px; white-space: nowrap;">NIS</th>
        <th style="border: 3px solid black; padding: 8px; white-space: nowrap;">Email</th>
        <th style="border: 3px solid black; padding: 8px; white-space: nowrap;">No Telp</th>
        <th style="border: 3px solid black; padding: 8px; white-space: nowrap;">Alamat</th>
        <th style="border: 3px solid black; padding: 8px; white-space: nowrap;">Kelas</th>
        <th style="border: 3px solid black; padding: 8px; white-space: nowrap;">Status</th>
    </tr>
    @foreach ($siswa as $key => $item)
    <tr>
        <td style="border: 3px solid black; padding: 8px; white-space: nowrap;">{{ $key+1 }}</td>
        <td style="border: 3px solid black; padding: 8px; white-space: nowrap;">{{ $item->dsiswa_nama }}</td>
        <td style="border: 3px solid black; padding: 8px; white-space: nowrap;">{{ $item->dsiswa_nis }}</td>
        <td style="border: 3px solid black; padding: 8px; white-space: nowrap;">{{ $item->dsiswa_email }}</td>
        <td style="border: 3px solid black; padding: 8px; white-space: nowrap;">{{ $item->dsiswa_no_telp }}</td>
        <td style="border: 3px solid black; padding: 8px; white-space: nowrap;">{{ $item->dsiswa_alamat }}</td>
        <td style="border: 3px solid black; padding: 8px; white-space: nowrap;">{{ $item->dkelas_nama_kelas }}</td>
        <td style="border: 3px solid black; padding: 8px; white-space: nowrap;">{{ $item->dsiswa_sts }}</td>
    </tr>
    @endforeach
</table>
