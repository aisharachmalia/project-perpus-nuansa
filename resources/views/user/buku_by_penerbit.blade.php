@extends('userz')
@section('content')
    <section class="hero">
        <div class="container2">
            <h1 class="aesthetic-title">Nuansa Baca</h1>
            <p>Selamat datang di Nuansa Baca!</p>
        </div>
    </section>

    {{-- <section class="search">
        <div class="container4">
            <form>
                <input type="text" placeholder="Cari Buku" />
                <button type="submit">Cari</button>
            </form>
        </div>
    </section> --}}

    <section class="author">
        <div class="container5">
            @if ($buku->isEmpty())
                {{-- Jika data buku kosong --}}
                <p class="empty-data-message text-center">Tidak ada data buku untuk ditampilkan.</p>
            @else
                <div class="row">
                    @foreach ($buku as $item)
                        <div class="col-2">
                            <a href="{{ route('document.detail', ['id' => Crypt::encryptString($item->id_dbuku)]) }}">
                                <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                                    <img src="{{ asset('storage/cover/' . $item->dbuku_cover) }}"
                                        class="img-fluid rounded-start" alt="{{ $item->dbuku_judul }}"
                                        style="height: 100%; width: 100%; object-fit: cover;">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
