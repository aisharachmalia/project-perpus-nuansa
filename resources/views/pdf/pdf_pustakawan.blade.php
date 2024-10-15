    <h1>
        <b>{{ $title }}</b>
    </h1>

    <table border="1" cellpadding="2" class="table table-striped">
        @php
        $no = 1;
        @endphp
        <tr>
            <th width="5%">No</th>
            <th width="20%">Nama</th>
            <th width="20%">Email</th>
            <th width="10%">No.Telepon</th>
            <th width="20%">Alamat</th>
        </tr>
        @foreach ($ps as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->dpustakawan_nama }}</td>
                <td>{{ $item->dpustakawan_email }}</td>
                <td>{{ $item->dpustakawan_no_telp }}</td>
                <td>{{ $item->dpustakawan_alamat }}</td>
            </tr>
        @endforeach
    </table>
