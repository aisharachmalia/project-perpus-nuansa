<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Nuansa Baca</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/logoNuansa1.ico')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
        <style>
            body {
                font-family: 'Arial', sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f7f9fc;
            }
            .hero {
                background-color: #277a32;
                color: white;
                padding: 50px 0;
                text-align: center;
            }
            .hero h1 {
                font-size: 3rem;
                font-weight: bold;
            }
            .container-guide {
                padding: 20px;
                background: white;
                margin: 20px auto;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                max-width: 800px;
            }
            h2 {
                margin-top: 20px;
                font-size: 1.8rem;
                color: #277a32;
            }
            ol, ul {
                padding-left: 20px;
            }
            li {
                margin-bottom: 15px;
            }
            .contact-info p {
                margin-bottom: 10px;
            }
            .contact-info i {
                color: #277a32;
                margin-right: 8px;
            }
        </style>
    </head>
    <body>
@extends('userz')
@section('content')

<section class="hero">
    <div class="container">
        <h1>Panduan Peminjaman Buku</h1>
        <p class="lead">Kemudahan akses literasi untuk semua.</p>
    </div>
</section>

<section class="about">
    <div class="container-tentang">
        <h2><i class="fas fa-book-reader"></i> Langkah-langkah Peminjaman Buku</h2>
        <ol>
            <li>
                <strong>Mencari Buku:</strong> 
                <p>Gunakan katalog digital di perpustakaan atau akses melalui portal <em>online</em> untuk menemukan buku yang Anda cari.</p>
            </li>
            <li>
                <strong>Mengisi Formulir Peminjaman:</strong> 
                <p>Kunjungi bagian layanan peminjaman dan isi formulir dengan informasi buku dan data pribadi Anda.</p>
            </li>
            <li>
                <strong>Verifikasi dan Konfirmasi:</strong> 
                <p>Petugas perpustakaan akan memverifikasi ketersediaan buku dan memproses peminjaman Anda.</p>
            </li>
            <li>
                <strong>Menerima Buku:</strong> 
                <p>Ambil buku yang sudah dipinjam dari petugas setelah proses selesai.</p>
            </li>
            <li>
                <strong>Mengembalikan Buku:</strong> 
                <p>Kembalikan buku sesuai dengan tanggal yang tertera untuk menghindari denda keterlambatan.</p>
            </li>
        </ol>

        <h2><i class="fas fa-info-circle"></i> Ketentuan Peminjaman</h2>
        <ul>
            <li>Maksimal 3 buku dapat dipinjam dalam satu waktu.</li>
            <li>Durasi peminjaman adalah 14 hari, dengan opsi perpanjangan selama 7 hari jika buku belum dipesan oleh orang lain.</li>
            <li>Buku yang terlambat dikembalikan akan dikenakan denda sebesar Rp2.000/hari.</li>
            <li>Buku yang hilang atau rusak harus diganti dengan buku serupa atau membayar biaya penggantian.</li>
        </ul>

        <h2><i class="fas fa-lightbulb"></i> Tips Memanfaatkan Perpustakaan</h2>
        <ul>
            <li>Gunakan katalog digital untuk mencari koleksi terbaru.</li>
            <li>Manfaatkan ruang diskusi untuk belajar kelompok.</li>
            <li>Bawa kartu perpustakaan setiap kali berkunjung.</li>
        </ul>

        <h2><i class="fas fa-phone-alt"></i> Kontak Petugas Perpustakaan</h2>
        <div class="contact-info">
            <p><i class="fas fa-map-marker-alt"></i> Jl. Pendidikan No. 5, Jakarta</p>
            <p><i class="fas fa-phone"></i> (021) 123-4567</p>
            <p><i class="fas fa-envelope"></i> perpustakaan@sekolah.sch.id</p>
        </div>
    </div>
</section>

@endsection
</body>
</html>
