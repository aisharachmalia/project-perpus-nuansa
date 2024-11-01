@extends('userz')
@section('content')
<section class="hero">
    <div class="container2">
        <h1 class="aesthetic-title">Perpustakaan SMK</h1>
        <p>Selamat datang di halaman perpustakaan SMK!</p>
        <button class="button">Cari Tahu Lebih Banyak</button>
    </div>
</section>

<section class="search">
    <div class="container4">
        <form>
            <input type="text" placeholder="Cari Buku" />
            <button type="submit">Cari</button>
        </form>
    </div>
</section>
<section class="author">
  <div class="container5">
      {{-- <h1 class="penulis">Penulis</h1> --}}
      <div class="row">
        @foreach($buku as $item) <!-- Pastikan $items di-passing ke view -->
          <div class="col-2">
            <a href="{{ route('document.detail', ['id' => $item->id_dbuku]) }}">
              <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                <img src="{{ asset('storage/cover/' . $item->dbuku_cover) }}" 
                     class="img-fluid rounded-start" 
                     alt="{{ $item->dbuku_judul }}" 
                     style="height: 100%; width: 100%; object-fit: cover;">
              </div>
            </a>
          </div>
        @endforeach
      </div>
  </div>
</section>

@endsection
