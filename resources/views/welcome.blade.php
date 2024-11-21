@extends('userz')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Muli', sans-serif;
            box-sizing: border-box;
            overflow-x: hidden;
        }
    </style>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container2">
            <h1 class="aesthetic-title">Nuansa Baca</h1>
            <p>Selamat datang di halaman Nuansa Baca! Temukan Dunia Pengetahuan</p>
        </div>
    </section>

    <!-- Author Section -->
    <section class="author">
        <div class="container5">
            <h1 class="penulis">Penulis</h1>
            <div class="row">
                <!-- Penulis Favorit -->
                <div class="col-4">
                    <a style="text-decoration:none" href="{{ route('penulis.favorit') }}" class="text-decoration-none">
                        <div class="card card-penulis mb-3" style="max-width: 540px;">
                            <img src="https://i.pinimg.com/enabled_lo/564x/24/95/63/2495635bcea49ecfc842dd5d2b94d85e.jpg"
                                class="img-fluid rounded-start" alt="Penulis Favorit"
                                style="height: 100%; width: 100%; object-fit: cover;">
                            <div class="penulis-judulz">Penulis Favorit</div>
                        </div>
                    </a>
                </div>
                <!-- Penulis Asing -->
                <div class="col-4">
                    <a style="text-decoration:none" href="{{ route('penulis.asing') }}" class="text-decoration-none">
                        <div class="card card-penulis mb-3" style="max-width: 540px;">
                            <img src="https://i.pinimg.com/enabled_lo/564x/24/95/63/2495635bcea49ecfc842dd5d2b94d85e.jpg"
                                class="img-fluid rounded-start" alt="Penulis Asing"
                                style="height: 100%; width: 100%; object-fit: cover;">
                            <div class="penulis-judulz">Penulis Asing</div>
                        </div>
                    </a>
                </div>
                <!-- Penulis Lokal -->
                <div class="col-4">
                    <a style="text-decoration:none" href="{{ route('penulis.lokal') }}" class="text-decoration-none">
                        <div class="card card-penulis mb-3" style="max-width: 540px;">
                            <img src="https://i.pinimg.com/enabled_lo/564x/24/95/63/2495635bcea49ecfc842dd5d2b94d85e.jpg"
                                class="img-fluid rounded-start" alt="Penulis Lokal"
                                style="height: 100%; width: 100%; object-fit: cover;">
                            <div class="penulis-judulz">Penulis Lokal</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Buku Rekomendasi Section -->
    <section class="author">
        <div class="container5">
        <h2 class="penulis">Rekomendasi Buku</h2>
        <div class="container">
            @foreach ($datadepan as $item)
                <div class="carousel-items">
                    <a style="text-decoration:none" href="{{ route('document.detail', ['id' => Crypt::encryptString($item->id_dbuku)]) }}">
                        <img class="carousel-item__img" src="{{ $item->dbuku_cover }}"
                            alt="{{ $item->dbuku_judul }}" />
                    </a>
                    <div class="carousel-item__details">
                     
                        <h5 class="carousel-item__details--title">{{ $item->dbuku_judul }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </section>

    <!-- Penerbit Section -->
    <section class="author">
        <div class="container5">
            <h1 class="penulis">Penerbit</h1>
            <div class="row">
                @foreach ($pnb as $item)
                    <div class="col-3">
                        <a style="text-decoration:none" href="{{ route('BukuByPenerbit', \Crypt::encryptString($item->id_dpenerbit)) }}"
                            class="text-decoration-none">
                            <div class="card card-penulis mb-3" style="max-width: 540px;">
                                <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg"
                                    class="img-fluid rounded-start" alt="Penerbit {{ $item->dpenerbit_nama_penerbit }}"
                                    style="height: 100%;  width: 100%; object-fit: cover;">
                                <div class="penulis-judul">{{ $item->dpenerbit_nama_penerbit }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
