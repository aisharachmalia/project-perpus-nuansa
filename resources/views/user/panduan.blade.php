@extends('userz')
@section('content')
<style>
    
</style>
<section class="hero">
    <div class="container2">
        <h1 class="aesthetic-title">Perpustakaan SMK</h1>
        <p>Selamat datang di halaman perpustakaan SMK! Temukan Dunia Pengetahuan</p>
        <button class="button">Cari Tahu Lebih Banyak</button>
    </div>
</section>

<!-- Navigation Menu -->
<nav class="library-nav">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#peminjaman">Peminjaman Buku</a></li>
        <li><a href="#pengembalian">Pengembalian Buku</a></li>
        <li><a href="#fasilitas">Fasilitas</a></li>
        <li><a href="#aturan">Aturan & Etika</a></li>
        <li><a href="#jadwal">Jadwal</a></li>
    </ul>
</nav>


<!-- Section: Peminjaman Buku -->
<section id="peminjaman" class="guide-section">
    <div class="container">
        <h2>Panduan Peminjaman Buku</h2>
        <p>Langkah-langkah untuk meminjam buku di perpustakaan:</p>
        <ul>
            <li>Cari buku yang ingin Anda pinjam melalui katalog online atau langsung di perpustakaan.</li>
            <li>Ambil buku dari rak atau minta bantuan petugas perpustakaan jika diperlukan.</li>
            <li>Bawa buku ke meja layanan untuk proses peminjaman. Kartu identitas siswa diperlukan.</li>
            <li>Simpan tanda terima peminjaman sebagai bukti dan periksa batas waktu pengembalian.</li>
        </ul>
    </div>
</section>

<!-- Section: Pengembalian Buku -->
<section id="pengembalian" class="guide-section">
    <div class="container">
        <h2>Panduan Pengembalian Buku</h2>
        <p>Ikuti langkah berikut untuk mengembalikan buku yang telah dipinjam:</p>
        <ul>
            <li>Kembalikan buku tepat waktu untuk menghindari denda keterlambatan.</li>
            <li>Buku dapat dikembalikan di meja layanan atau kotak pengembalian (jika tersedia).</li>
            <li>Jika buku rusak atau hilang, segera laporkan ke petugas perpustakaan.</li>
            <li>Pastikan buku dalam kondisi baik dan lengkap saat dikembalikan.</li>
        </ul>
    </div>
</section>

<!-- Section: Fasilitas Perpustakaan -->
<section id="fasilitas" class="guide-section">
    <div class="container">
        <h2>Fasilitas Perpustakaan</h2>
        <p>Perpustakaan menyediakan berbagai fasilitas untuk kenyamanan Anda:</p>
        <div class="fasilitas-list">
            <div class="fasilitas-item">
                <img src="reading_room.jpg" alt="Ruang Baca Nyaman">
                <h3>Ruang Baca Nyaman</h3>
                <p>Tempat yang tenang dan nyaman untuk membaca dan belajar.</p>
            </div>
            <div class="fasilitas-item">
                <img src="computer_access.jpg" alt="Akses Internet & Komputer">
                <h3>Akses Internet & Komputer</h3>
                <p>Gunakan komputer perpustakaan dengan akses internet untuk riset dan tugas sekolah.</p>
            </div>
            <div class="fasilitas-item">
                <img src="discussion_room.jpg" alt="Ruang Diskusi">
                <h3>Ruang Diskusi</h3>
                <p>Fasilitas untuk diskusi kelompok atau sesi belajar bersama.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section: Aturan & Etika -->
<section id="aturan" class="guide-section">
    <div class="container">
        <h2>Aturan & Etika di Perpustakaan</h2>
        <p>Untuk menjaga kenyamanan bersama, ikuti aturan berikut:</p>
        <ul>
            <li>Jaga ketenangan di area baca. Gunakan suara pelan saat berbicara.</li>
            <li>Jaga kebersihan, buang sampah di tempat yang disediakan.</li>
            <li>Dilarang membawa makanan dan minuman ke dalam ruang baca.</li>
            <li>Hormati privasi pengguna lain dan hindari gangguan.</li>
            <li>Gunakan fasilitas dengan bijaksana dan bertanggung jawab.</li>
        </ul>
    </div>
</section>

<!-- Section: Jadwal -->
<section id="jadwal" class="guide-section">
    <div class="container">
        <h2>Jadwal Operasional Perpustakaan</h2>
        <p>Perpustakaan kami buka pada waktu-waktu berikut:</p>
        <ul>
            <li><strong>Senin - Jumat:</strong> 08.00 - 16.00 WIB</li>
            <li><strong>Sabtu:</strong> 08.00 - 12.00 WIB</li>
            <li><strong>Minggu & Hari Libur Nasional:</strong> Tutup</li>
        </ul>
    </div>
</section>
@endsection
@push('scripts')
    <!-- JavaScript for Smooth Scroll -->
<script>
    document.querySelectorAll('nav ul li a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush