<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Siswa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f0f0f0; /* Warna latar belakang yang lebih cerah */
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 2px solid #4CAF50; /* Garis bawah untuk judul */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0; 
            background-color: #fff;
            border-radius: 8px; /* Menambahkan sudut melengkung */
            overflow: hidden; /* Menghilangkan sudut yang tajam */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan lebih halus */
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd; /* Garis pemisah antara baris */
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Warna latar belakang yang lebih cerah untuk baris genap */
        }
        tr:hover {
            background-color: #e0f7e0; /* Warna latar belakang saat hover */
        }
        td:nth-child(1) {
            background-color: #fefec2; /* Warna latar belakang khusus untuk kolom pertama */
            font-weight: bold; /* Menebalkan teks */
        }
        td img {
            width: 50px; /* Lebar gambar */
            height: auto; /* Mempertahankan rasio aspek */
            border-radius: 5px; /* Sudut melengkung untuk gambar */
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 24px; /* Mengubah ukuran font untuk judul di layar kecil */
            }
            th, td {
                padding: 8px; /* Mengurangi padding pada perangkat kecil */
            }
        }
    </style>
    
    
</head>
<body>

<h1>Rekap Siswa</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>NIS</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Alamat</th>
            {{-- <th>Kelas</th> --}}
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->dsiswa_nama }}</td>
                <td>{{ $item->dsiswa_nis }}</td>
                <td>{{ $item->dsiswa_email }}</td>
                <td>{{ $item->dsiswa_no_telp }}</td>
                <td>{{ $item->dsiswa_alamat }}</td>
                {{-- <td>{{ $item->dkelas_nama_kelas }}</td> --}}
               <td> {{ $item->dsiswa_sts == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
      