@extends('userz')
@section('content')
<style>
.library-nav {
    background: linear-gradient(45deg, #2c5030, #2abb4c); 
    padding: 15px 0;
    text-align: center;
    border-bottom: 4px solid #2980b9;
    position: sticky;
    top: 0;
    z-index: 1000;
    overflow-x: auto; /* Membuat navbar bisa digulirkan secara horizontal */
    white-space: nowrap; /* Menghindari pemecahan baris dalam navbar */
    width: 100%; /* Pastikan navbar mengambil lebar penuh */
    box-sizing: border-box; /* Pastikan padding tidak menambah lebar navbar */
}

.library-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: nowrap; /* Item navbar tetap dalam satu baris */
    gap: 30px; /* Menambah jarak antar item navbar */
    overflow-x: auto; /* Membuat item navbar bisa digulirkan secara horizontal */
    justify-content: center; /* Menyusun item navbar di tengah */
}

.library-nav ul li {
    display: inline-block;
}

.library-nav ul li a {
    font-size: 1.1em;
    font-weight: bold;
    color: white;
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 5px;
    transition: background 0.3s, transform 0.3s;
}

.library-nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

/* Optional: Navbar item active state */
.library-nav ul li a.active {
    background-color: #1e9c40;
}

/* Responsive Design */
@media (max-width: 768px) {
    .library-nav ul {
        gap: 15px; /* Mengurangi jarak pada layar kecil */
    }

    .library-nav ul li a {
        font-size: 1em; /* Menurunkan ukuran font pada perangkat kecil */
        padding: 8px 15px;
    }
}

.guide-section {
    padding: 40px 0;
    background-color: #f5f5f5;
}

.guide-section h2 {
    text-align: start;
    margin: 20px;
    font-size: 2em;
    color: #2c5030;
}

.container5 {
    padding: 20px;
}

/* Card and Image Styles */
.card-penulis {
    max-width: 100%;
    transition: transform 0.3s;
}

.card-penulis:hover {
    transform: scale(1.05);
}

.img-fluid {
    border-radius: 5px;
    height: 100%;
    width: 100%;
    object-fit: cover;
}

/* Control row gap */
.row {
    gap: 15px; /* Adjust gap to control spacing between cards */
}

.see-more {
    display: inline-block;
    margin: 20px auto;
    padding: 10px 20px;
    font-size: 1.2em;
    font-weight: bold;
    background-color: #2abb4c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.see-more:hover {
    background-color: #249942;
}

.penulis-section {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
}

.books-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 buku per baris */
    gap: 10px;
    padding-bottom: 10px;
}

.book-item {
    text-align: center;
}

.book-item img {
    width: 50%;
    height: auto;
    border-radius: 5px;
}

.see-more {
    margin-top: 10px;
}
    </style>

    <section class="hero">
        <div class="container2">
            <h1 class="aesthetic-title">Nuansa Baca </h1>
            <p>Selamat datang di Nuansa Baca! Temukan Dunia Pengetahuan</p>
        </div>
    </section> 
    <h1 class="text-center mb-4 mt-5">Penulis Lokal</h1>   
    <div class="containers my-4">
        <div class="row">
            @foreach($penulisLokal as $penulis)
                <div class="col-md-12 penulis-section">
                    <h2 class="text-primary">{{ $penulis->dpenulis_nama_penulis }}</h2>
                    <p class="text-muted">{{ $penulis->dpenulis_kewarganegaraan }}</p>
                    
                    <div class="books-container" id="books-{{ $penulis->id_dpenulis }}">
                        @foreach($penulis->buku->take(6) as $buku) <!-- Tampilkan 6 buku pertama -->
                            <div class="book-item">
                                <a href="{{ route('document.detail', ['id' => $buku->id_dbuku]) }}">
                                <img src="{{ asset('storage/cover/' . $buku->dbuku_cover) }}" alt="{{ $buku->dbuku_judul }}">
                                </a>
                                <p class="fw-bold mt-2">{{ $buku->dbuku_judul }}</p>
                                <small class="text-muted">{{ $buku->dbuku_thn_terbit }}</small>
                            </div>
                        @endforeach
                    </div>
    
                    @if($penulis->jumlahBuku > 6)
                        <button class="btn btn-outline-primary see-more" 
                                data-penulis-id="{{ $penulis->id_dpenulis }}" 
                                data-offset="6">
                            See More
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.see-more').on('click', function() {
                let button = $(this);
                let penulisId = button.data('penulis-id');
                let offset = button.data('offset');
    
                $.ajax({
                    url: "{{ route('penulis.loadMoreBooksLokal') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_dpenulis: penulisId,
                        offset: offset
                    },
                    success: function(data) {
                        let newBooksHTML = '';
                        data.forEach(function(buku) {
                            newBooksHTML += 
                                '<div class="book-item">' +
                                '<img src="{{ asset('storage/cover/') }}/' + buku.dbuku_cover + '" alt="' + buku.dbuku_judul + '">' +
                                '<p class="fw-bold mt-2">' + buku.dbuku_judul + '</p>' +
                                '<small class="text-muted">' + buku.dbuku_thn_terbit + '</small>' +
                                '</div>';
                        });
    
                        $('#books-' + penulisId).append(newBooksHTML); 
                        button.data('offset', offset + 6);
                        if (data.length < 6) {
                            button.hide();
                        }
                    }
                });
            });
        });
    </script>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
