@extends('userz')
@section('content')

<section class="hero">
    <div class="container2">
        <h1 class="aesthetic-title">History</h1>
    </div>
</section>

<section class="author">
    <div class="container5">
        <div class="row">
            @if ($bacaOnline->isEmpty())
                <div class="col-12">
                    <p class="text-center">Anda Belum Membaca Buku </p>
                </div>
            @endif
            @foreach ($bacaOnline as $item)
                <!-- Pastikan $items di-passing ke view -->
                <div class="col-2">
                    <a href="{{ route('document.detail', ['id' => Crypt::encryptString($item->id_dbuku)]) }}">
                        <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                            <img src="{{ $item->dbuku_cover }}" class="carousel-item__img"
                                alt="{{ $item->dbuku_judul }}" style="height: 300px; width: 100%; object-fit:cover ;">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
