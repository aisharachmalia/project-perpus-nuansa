<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1>
        <b>{{ $title }}</b>
    </h1>

    <table class="table table-striped">
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
</body>

</html>
