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
            <h1 class="aesthetic-title">Nuansa Baca</h1>
            <p>Selamat datang di Nuansa Baca! Temukan Dunia Pengetahuan</p>
        </div>
    </section>

    <nav class="library-nav">
        <ul>
            @foreach ($datadepan as $item)
                <li><a href="#{{ $item->id_dpenulis }}">{{ $item->dpenulis_nama_penulis }}</a></li>
            @endforeach
        </ul>
    </nav>

    @foreach ($datadepan as $item)
        <section id="{{ $item->id_dpenulis }}" class="guide-section">
            <h2 style="text-align: start;margin-bottom: 20px;font-size: 2em;color: #2c5030;margin-left: 20px">
                {{ $item->dpenulis_nama_penulis }}</h2>
            <ul>
                @foreach ($bukuByPenulis as $item)
                    <div class="carousel-item">
                        <a href="{{ route('document.detail', ['id' => $item[0]->id_dbuku]) }}">
                            <img class="carousel-item__img" src="{{ asset('storage/cover/' . $item[0]->dbuku_cover) }}"
                                alt="{{ $item[0]->dbuku_judul }}" />
                        </a>
                        <div class="carousel-item__details">
                            <div class="controls">
                                <span class="fas fa-play-circle"></span>
                                <span class="fas fa-plus-circle"></span>
                            </div>
                            <h5 class="carousel-item__details--title">{{ $item[0]->dbuku_judul }}</h5>
                            <h6 class="carousel-item__details--subtitle">Last updated 3 mins ago</h6>
                        </div>
                    </div>
                @endforeach
            </ul>
        </section>
        
    @endforeach
@endsection
