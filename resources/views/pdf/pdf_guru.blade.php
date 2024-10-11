<h1 style="text-align:center">{{ $title }}</h1>

<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; ">
    <tr style="background-color: #f2f2f2;">
        <th width="5%" style="text-align: center">No</th>
        <th style="text-align: center">NIP</th>
        <th>Nama</th>
        <th width="21%">Email</th>
        <th>No. Telp</th>
        <th width="17%">Alamat</th>
        <th>Mata Pelajaran</th>
    </tr>
    <tbody>
        @foreach ($gr as $item)
            <tr>
                <td style="text-align: center;background-color: #fefe76" width="5%">{{ $loop->iteration }}</td>
                <td>{{ $item->dguru_nip }}</td>
                <td>{{ $item->dguru_nama }}</td>
                <td width="21%">{{ $item->dguru_email }}</td>
                <td>{{ $item->dguru_no_telp }}</td>
                <td width="17%">{{ $item->dguru_alamat }}</td>
                <td>{{ $item->dmapel_nama_mapel }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
