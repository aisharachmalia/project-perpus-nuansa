<h1 style="text-align:center; margin-bottom: 20px;">
    <b>{{ $title }}</b>
</h1>

<table border="1" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    @php
        $no = 1;
    @endphp
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th width="5%" style="text-align: center; padding: 10px;">No</th>
            <th width="15%" style="text-align: center; padding: 10px;">Nama</th>
            <th width="20%" style="text-align: center; padding: 10px;">Email</th>
            <th width="15%" style="text-align: center; padding: 10px;">No. Telepon</th>
            <th width="20%" style="text-align: center; padding: 10px;">Alamat</th>
            <th width="10%" style="text-align: center; padding: 10px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ps as $item)
            <tr>
                <td style="text-align: center; padding: 8px;">{{ $no++ }}</td>
                <td style="text-align: center; padding: 8px;">{{ $item->dpustakawan_nama }}</td>
                <td style="text-align: center; padding: 8px;">{{ $item->dpustakawan_email }}</td>
                <td style="text-align: center; padding: 8px;">{{ $item->dpustakawan_no_telp }}</td>
                <td style="text-align: center; padding: 8px;">{{ $item->dpustakawan_alamat }}</td>
                <td style="text-align: center; padding: 8px;">
                    @if($item->dpustakawan_status == 1)
                        Aktif
                    @elseif($item->dpustakawan_status == 2)
                        Tidak Aktif
                    @else
                        Tidak Aktif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
