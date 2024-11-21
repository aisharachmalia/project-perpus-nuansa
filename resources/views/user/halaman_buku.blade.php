@extends('userz')
@section('content')
    <section class="hero">
        <div class="container2">
            <h1 class="aesthetic-title">Nuansa Baca</h1>
            <p>Selamat datang di Nuansa Baca!</p>
        </div>
    </section>

    <section class="search">
        <div class="container4">
            <form action="{{ route('buku.search') }}" method="GET">
                <input type="text" name="query" placeholder="Cari Buku" />
                <button type="submit">Cari</button>
            </form>
        </div>
    </section>
    <section class="author">
        <div class="container5">

            @if (!empty($query))
                <h3>Hasil pencarian untuk: <strong>{{ $query }}</strong></h3>
            @endif
            <div class="row">
                @foreach ($buku as $item)
                    <!-- Pastikan $items di-passing ke view -->
                    <div class="carousel-items col-2">
                        <a href="{{ route('document.detail', ['id' => Crypt::encryptString($item->id_dbuku)]) }}">
                            <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                                <img src="{{ $item->dbuku_cover }}" class="img-fluid rounded-start"
                                    alt="{{ $item->dbuku_judul }}" style="height: 300px; width: 100%; object-fit:cover ;">
                            </div>
                        </a>
                        <div class="carousel-item__details">
                            <div class="controls">
                                <span class="fas fa-play-circle"></span>
                                <span class="fas fa-plus-circle"></span>
                            </div>
                            <h5 class="carousel-item__details--title">{{ $item->dbuku_judul }}</h5>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
