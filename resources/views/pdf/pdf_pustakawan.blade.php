    
    <h1 style="text-align:center; margin-bottom: 20px;">
        <b>{{ $title }}</b>
    </h1>

    <table border="1" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        @php
        $no = 1;
        @endphp
        <tr>
            <th width="5%" style="text-align: center;">No</th>
            <th width="15%"style="text-align: center;">Nama</th>
            <th width="20%"style="text-align: center;">Email</th>
            <th width="15%"style="text-align: center;">No.Telepon</th>
            <th width="20%"style="text-align: center;">Alamat</th>
            <th width="10%"style="text-align: center;">Status</th>
        </tr>
        @foreach ($ps as $item)
            <tr>
                <td style="text-align: center;">{{ $no++ }}</td>
                <td style="text-align: center;">{{ $item->dpustakawan_nama }}</td>
                <td style="text-align: center;">{{ $item->dpustakawan_email }}</td>
                <td style="text-align: center;">{{ $item->dpustakawan_no_telp }}</td>
                <td style="text-align: center;">{{ $item->dpustakawan_alamat }}</td>
                <td style="text-align: center;">
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
    </table>
