@extends('userz')
@section('content')
    <style>
        /* Styles seperti yang sebelumnya */
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

        .penulis-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .books-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 buku per baris */
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

        /* Pesan Data Kosong */
    </style>

    <section class="hero">
        <div class="container2">
            <h1 class="aesthetic-title">Nuansa Baca </h1>
            <p>Selamat datang di Nuansa Baca! Temukan Dunia Pengetahuan</p>
        </div>
    </section>

    <h1 class="text-center mb-4 mt-5">Penulis Asing </h1>  
    @if ($penulisAsing->isEmpty())
    <p class="empty-data-message text-center">Tidak ada data buku untuk ditampilkan.</p>
    @else 
    <div class="containers my-4">
       
            <div class="row">
                @foreach ($penulisAsing as $penulis)
                    <div class="col-md-12 penulis-section">
                        <h2 class="text-primary">{{ $penulis->dpenulis_nama_penulis }}</h2>
                        <p class="text-muted">{{ $penulis->dpenulis_kewarganegaraan }}</p>

                        <div class="books-container" id="books-{{ $penulis->id_dpenulis }}">
                            @foreach ($penulis->buku->take(6) as $buku)
                                <!-- Tampilkan 6 buku pertama -->
                                <div class="book-item">
                                    <a href="{{ route('document.detail', ['id' => Crypt::encryptString($item->id_dbuku)]) }}">
                                        <img src="{{ asset('storage/cover/' . $buku->dbuku_cover) }}"
                                            alt="{{ $buku->dbuku_judul }}">
                                    </a>
                                    <p class="fw-bold mt-2">{{ $buku->dbuku_judul }}</p>
                                    <small class="text-muted">{{ $buku->dbuku_thn_terbit }}</small>
                                </div>
                            @endforeach
                        </div>

                        @if ($penulis->jumlahBuku > 6)
                            <button class="btn btn-outline-primary see-more" data-penulis-id="{{ $penulis->id_dpenulis }}"
                                data-offset="6">
                                See More
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('.see-more').on('click', function() {
                let button = $(this);
                let penulisId = button.data('penulis-id');
                let offset = button.data('offset');

                $.ajax({
                    url: "{{ route('penulis.loadMoreBooksAsing') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_dpenulis: penulisId,
                        offset: offset
                    },
                    success: function(data) {
                        // Menambahkan buku-buku baru di bawah (dalam grid layout)
                        let newBooksHTML = '';
                        data.forEach(function(buku) {
                            newBooksHTML +=
                                '<div class="book-item">' +
                                '<img src="{{ asset('storage/cover/') }}/' + buku
                                .dbuku_cover + '" alt="' + buku.dbuku_judul + '">' +
                                '<p class="fw-bold mt-2">' + buku.dbuku_judul + '</p>' +
                                '<small class="text-muted">' + buku.dbuku_thn_terbit +
                                '</small>' +
                                '</div>';
                        });

                        // Menambahkan buku baru setelah tombol "See More"
                        $('#books-' + penulisId).append(newBooksHTML);

                        // Update offset dan sembunyikan tombol jika tidak ada buku lagi
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
