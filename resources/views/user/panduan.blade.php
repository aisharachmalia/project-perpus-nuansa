@extends('userz')
@section('content')

<style>

/* Library Navigation */
.library-nav {
    background: linear-gradient(45deg, #2c5030, #2abb4c);
    padding: 15px 0;
    text-align: center;
    border-bottom: 4px solid #2980b9;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.library-nav ul {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
    gap: 25px;
}

.library-nav ul li a {
    font-size: 1.1em;
    font-weight: bold;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background 0.3s, transform 0.3s;
}

.library-nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

/* Section Styles */
.guide-section {
    padding: 40px 0;
    background-color: #f5f5f5;
}

.guide-section h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 2em;
    color: #2c5030;
}

.guide-section p {
    text-align: center;
    margin-bottom: 30px;
}

.guide-section ul {
    list-style: none;
    padding: 0;
}

.guide-section ul li {
    margin: 10px 0;
    font-size: 1.1em;
}

/* Facility Section */
.fasilitas-list {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 20px;
}

.fasilitas-item {
    text-align: center;
    width: 30%;
    background-color: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.fasilitas-item img {
    width: 100%;
    border-radius: 5px;
}

.fasilitas-item:hover {
    transform: scale(1.05);
}
</style>
@push('scripts')
<script>
    document.querySelectorAll('.library-nav ul li a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush

</style>


<section class="hero">
    <div class="container2">
        <h1 class="aesthetic-title">Perpustakaan SMK</h1>
        <p>Selamat datang di halaman perpustakaan SMK! Temukan Dunia Pengetahuan</p>
        <button class="button">Cari Tahu Lebih Banyak</button>
    </div>
</section>

<nav class="library-nav">
    <ul>
        <li><a href="#peminjaman">Peminjaman Buku</a></li>
        <li><a href="#pengembalian">Pengembalian Buku</a></li>
        <li><a href="#aturan">Aturan & Etika</a></li>
    </ul>
</nav>

<section id="peminjaman" class="guide-section">
    <div class="container">
        <h2>Panduan Peminjaman Buku</h2>
        {{-- <p>Langkah-langkah untuk meminjam buku di perpustakaan:</p> --}}
        <ul>
            <li>Cari buku yang ingin Anda pinjam melalui katalog online atau langsung di perpustakaan.</li>
            <li>Bawa buku ke meja layanan untuk proses peminjaman. Kartu identitas siswa diperlukan.</li>
            <li>Simpan tanda terima peminjaman sebagai bukti dan periksa batas waktu pengembalian.</li>
        </ul>
    </div>
</section>

<section id="pengembalian" class="guide-section">
    <div class="container">
        <h2>Panduan Pengembalian Buku</h2>
        {{-- <p>Ikuti langkah berikut untuk mengembalikan buku yang telah dipinjam:</p> --}}
        <ul>
            <li>Kembalikan buku tepat waktu untuk menghindari denda keterlambatan.</li>
            <li>Buku dapat dikembalikan di meja layanan atau kotak pengembalian (jika tersedia).</li>
        </ul>
    </div>
</section>
<section id="aturan" class="guide-section">
    <div class="container">
        <h2>Aturan & Etika di Perpustakaan</h2>
        <ul>
            <li>Jaga ketenangan di area baca.</li>
            <li>Dilarang membawa makanan dan minuman ke dalam ruang baca.</li>
        </ul>
    </div>
</section>

@endsection
