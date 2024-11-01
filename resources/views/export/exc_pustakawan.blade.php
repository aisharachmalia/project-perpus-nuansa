<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>No.Telepon</th>
        <th>Alamat</th>
        <th>Status</th>
    </tr>
    @foreach ($pustakawan as $key => $item)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$item->dpustakawan_nama}}</td>
            <td>{{$item->dpustakawan_email}}</td>
            <td>{{$item->dpustakawan_no_telp}}</td>
            <td>{{$item->dpustakawan_alamat}}</td>
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