<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Nuansa Baca</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/logoNuansa1.ico')}}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        @include('user.css')
        @stack('css')
    </head>
<style>
  
</style>
<body>
@extends('userz')
@section('content')
<section class="hero">
    <div class="container2">
        <h1 class="aesthetic-title">Nuansa Baca</h1>
        <p>Selamat datang di halaman Nuansa Baca! Temukan Dunia Pengetahuan</p>
    </div>
</section>
    <section class="about">
        <div class="container-tentang">
            <h2>Visi dan Misi</h2>
            <p><strong>Visi:</strong> Menjadi pusat literasi yang inovatif dan berdaya guna dalam mendukung pengembangan pengetahuan serta budaya baca di lingkungan sekolah.</p>
            <p><strong>Misi:</strong></p>
            <ul>
                <li>Meningkatkan minat baca siswa melalui berbagai koleksi dan program literasi.</li>
                <li>Menyediakan akses yang mudah dan luas terhadap sumber-sumber informasi terbaru.</li>
                <li>Mendukung proses pembelajaran siswa dan guru dengan koleksi dan fasilitas perpustakaan yang lengkap.</li>
                <li>Mendorong penggunaan teknologi dalam kegiatan literasi dan pembelajaran.</li>
            </ul>

            <h2>Sejarah Perpustakaan</h2>
            <p>Perpustakaan sekolah kami didirikan pada tahun 2005 dengan tujuan menjadi tempat sumber belajar yang mendukung kegiatan akademik di sekolah. Seiring waktu, perpustakaan kami terus berkembang, mulai dari koleksi buku yang semakin lengkap hingga digitalisasi layanan perpustakaan pada tahun 2020.</p>

            <h2>Fasilitas</h2>
            <ul>
                <li>Ruang Baca yang nyaman</li>
                <li>Komputer Akses Internet untuk riset</li>
                <li>Ruang Diskusi untuk kegiatan belajar kelompok</li>
                <li>Katalog Digital dan Koleksi E-book</li>
            </ul>

            <h2>Koleksi Buku</h2>
            <p>Perpustakaan kami memiliki lebih dari 5.000 koleksi buku, mencakup buku fiksi, non-fiksi, buku pelajaran, serta majalah dan jurnal ilmiah.</p>

            <h2>Tim Perpustakaan</h2>
            <p>Pustakawan kami siap melayani kebutuhan siswa dan guru, dipimpin oleh <strong>Ibu Aisyah</strong> sebagai kepala perpustakaan yang berdedikasi dalam mengelola berbagai program literasi.</p>

            <h2>Jadwal Operasional</h2>
            <p>Senin - Jumat: 08.00 - 16.00 WIB</p>
            <p>Sabtu, Minggu, dan Hari Libur Nasional: Tutup</p>

            <h2>Kontak Kami</h2>
            <p>Alamat: Jl. Pendidikan No. 5, Jakarta</p>
            <p>Telepon: (021) 123-4567</p>
            <p>Email: perpustakaan@sekolah.sch.id</p>
        </div>
    </section>

    @endsection
</body>
</html>
