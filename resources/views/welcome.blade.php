@extends('userz')
@section('content')
<style>
  body {
  margin: 0;
  font-family: 'Muli', sans-serif;
  box-sizing: border-box;
  overflow-x: hidden;
}
</style>

    <section class="hero">
        <div class="container2">
            <h1 class="aesthetic-title">Perpustakaan SMK</h1>
            <p>Selamat datang di halaman perpustakaan SMK! Temukan Dunia Pengetahuan</p>
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
            <h1 class="penulis">Penulis</h1>
            <div class="row">
              <div class="col-4">
                <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                  <img src="https://i.pinimg.com/enabled_lo/564x/24/95/63/2495635bcea49ecfc842dd5d2b94d85e.jpg" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                  <div class="penulis-judul" >
                    Penulis Favorit
                  </div>
                </div>
                
                
              </div>
              <div class="col-4">
                <div class="card card-penulis mb-3" style="max-width: 540px;">
                  <img src="https://i.pinimg.com/enabled_lo/564x/24/95/63/2495635bcea49ecfc842dd5d2b94d85e.jpg" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                       <div class="penulis-judul" >
                        Penulis Lokal
                      </div>
                </div>
                
              </div>
              <div class="col-4">
                <div class="card card-penulis mb-3" style="max-width: 540px;">
                  <img src="https://i.pinimg.com/enabled_lo/564x/24/95/63/2495635bcea49ecfc842dd5d2b94d85e.jpg" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                       <div class="penulis-judul" >
                        Penulis Terbaru
                      </div>
                </div>
                
              </div>
            </div>
        </div>
    </section>
    
    <section class="carousel">
      <h2 class="categories__title">Rekomendasi Buku</h2>
      <div class="carousel__container">
        @foreach ($datadepan as $item)
          <div class="carousel-item">
            <a href="{{ route('document.detail', ['id' => $item->id_dbuku]) }}">
            <img class="carousel-item__img" src="{{ asset('storage/cover/' .$item->dbuku_cover) }}" alt="{{ $item->dbuku_judul }}"/>
            </a>
            <div class="carousel-item__details">
              <div class="controls">
                <span class="fas fa-play-circle"></span>
                <span class="fas fa-plus-circle"></span>
              </div>
              <h5 class="carousel-item__details--title">{{ $item->dbuku_judul }}</h5>
              <h6 class="carousel-item__details--subtitle">Last updated 3 mins ago</h6>
            </div>
          </div>
        @endforeach
      </div>
    </section>
    
  
    <section class="author">
        <div class="container5">
            <h1 class="penulis">Penerbit</h1>
            <div class="row">
              <div class="col-3">
                <div class="card card-penulis mb-3" style="max-width: 540px;">
                  <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                       <div class="penulis-juduls" >
                        Gramedia
                      </div>
                </div>
                
              </div>
            <div class="col-3">
              <div class="card card-penulis mb-3" style="max-width: 540px;">
                <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
                     <div class="penulis-juduls" >
                      Gramedia Pustaka Utama
                    </div>
              </div>
            </div>
            <div class="col-3">
              <div class="card card-penulis mb-3" style="max-width: 540px;">
                <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
                     <div class="penulis-juduls" >
                      Penulis Terbaru
                    </div>
              </div>
            </div>
            <div class="col-3">
              <div class="card card-penulis mb-3" style="max-width: 540px;">
                <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
                     <div class="penulis-juduls" >
                      Visi Media
                    </div>
              </div>
            </div>
            <div class="col-3">
              <div class="card card-penulis mb-3" style="max-width: 540px;">
                <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
                     <div class="penulis-juduls" >
                     Pustaka Alvabet
                    </div>
              </div>
            </div>
            <div class="col-3">
              <div class="card card-penulis mb-3" style="max-width: 540px;">
                <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
                     <div class="penulis-juduls" >
                     Andi Publisher
                    </div>
              </div>
            </div>
            <div class="col-3">
              <div class="card card-penulis mb-3" style="max-width: 540px;">
                <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
                     <div class="penulis-juduls" >
                     Elex Media Komputindo
                    </div>
              </div>
            </div>
            <div class="col-3">
              <a href="">
              <div class="card card-penulis mb-3" style="max-width: 540px;">
                <img src="https://i.pinimg.com/564x/14/b7/15/14b715201694a3d4468d45468786ec01.jpg" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
                     <div class="penulis-juduls" >
                     Bhuana Ilmu Populer
                    </div>
              </div>
            </a>
            </div>
            </div>
        </div>
    </section>
@endsection
