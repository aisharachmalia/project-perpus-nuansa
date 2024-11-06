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
    </style>

    <section class="hero">
        <div class="container2">
            <h1 class="aesthetic-title">Nuansa Baca </h1>
            <p>Selamat datang di Nuansa Baca! Temukan Dunia Pengetahuan</p>
        </div>
    </section>

    <nav class="library-nav">
        <ul>
            @foreach ($pnls as $item)
                <li><a href="#{{ $item->id_dpenulis }}">{{ $item->dpenulis_nama_penulis }}</a></li>
            @endforeach
        </ul>
    </nav>

    @foreach ($pnls as $item)
        <section id="{{ $item->id_dpenulis }}" class="guide-section author">
            <div class="container5">
                <h2>{{ $item->dpenulis_nama_penulis }}</h2>
                <div class="row gx-3 gy-4"> <!-- Add gap control classes for better spacing -->
                    @foreach ($bukuByPenulis[$item->id_dpenulis] as $book)
                        <div class="col-2 d-flex"> <!-- Use flex to ensure equal height cards -->
                            <a href="{{ route('document.detail', ['id' => $book->id_dbuku]) }}">
                                <div class="card card-penulis mb-3" style="position: relative;">
                                    <img src="{{ asset('storage/cover/' . $book->dbuku_cover) }}" 
                                         class="img-fluid rounded-start" 
                                         alt="{{ $book->dbuku_judul }}">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endsection
