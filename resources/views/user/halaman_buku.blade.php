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
            <center>
                <div class="d-flex justify-content-center">
                    <div class="row">
                        @foreach ($buku as $item)
                            <div class="carousel-items col-2">
                                <a href="{{ route('document.detail', ['id' => Crypt::encryptString($item->id_dbuku)]) }}">
                                    <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                                        <img src="{{ $item->dbuku_cover }}" class="carousel-item__img"
                                            alt="{{ $item->dbuku_judul }}" style="height: 300px; width: 100%; object-fit:cover ;">
                                    </div>
                                </a>
                                <div class="carousel-item__details">
                                    <h5 class="carousel-item__details--title">{{ $item->dbuku_judul }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </center>
w            
            {{-- @php
            $response = Http::get('https://uinsgd.ac.id/wp-json/wp/v2/posts');
            $berita = $response->successful() ? $response->json() : [];
            $berita = collect($berita); // Ubah array menjadi koleksi jika perlu
            // <pre>{{ var_dump($berita) }}</pre>
            // dd($berita);
        @endphp
        
        
        @foreach ($berita->sortByDesc('created_at')->take(4) as $item)
                            <div class="d-flex align-items-start ">
                                <div class="about-img">
                                    @if (
                                        !empty($item['yoast_head_json']['og_image']) &&
                                            is_array($item['yoast_head_json']['og_image']) &&
                                            isset($item['yoast_head_json']['og_image'][0]['url']))
                                        <img src="{{ $item['yoast_head_json']['og_image'][0]['url'] }}"
                                          class="img-fluid rounded" alt="Image">
                                    @else
                                        <img src="{{ asset('default.png') }}" class="img-fluid w-100 rounded"
                                            alt="Gambar berita">
                                    @endif
                                </div>
                                <div class="ms-4">
                                    <h5><b><a
                                                href="berita/{{ $item['id'] }}">{{ $item['yoast_head_json']['title'] ?? 'No Title' }}</a></b>
                                    </h5>
                                    <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i>
                                        {{ date('d/m/Y', strtotime($item['date'])) }}
                                        <a href="#" class="text-body d-block float-end link-hover me-3"><i
                                                class="bi bi-person-circle"></i>
                                            {{ $item['yoast_head_json']['author'] }}</a></small>
                                </div>
                            </div>
                            <hr class="w-100">
                        @endforeach --}}
        </div>
    </section>
@endsection
