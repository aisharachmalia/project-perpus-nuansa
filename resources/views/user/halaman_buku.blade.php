@extends('userz')
@section('content')
<section class="hero">
    <div class="container2">
        <h1 class="aesthetic-title">Perpustakaan SMK</h1>
        <p>Selamat datang di halam perpustakaan SMK!</p>
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
          <div class="col-2">
            <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
              <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                   class="img-fluid rounded-start" 
                   alt="..." 
                   style="height: 100%; width: 100%; object-fit: cover;">
            </div>
          </div>
          <div class="col-2">
            <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
              </div>
            
          </div>
          <div class="col-2">
            <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
              </div>
            
          </div>
          <div class="col-2">
            <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
              </div>
            </div>
          <div class="col-2">
            <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
              </div>
            </div>
          <div class="col-2">
            <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
              </div>
            </div>
            
          </div>
        <div class="row">
            <div class="col-2">
              <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                     class="img-fluid rounded-start" 
                     alt="..." 
                     style="height: 100%; width: 100%; object-fit: cover;">
              </div>
            </div>
            <div class="col-2">
              <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                  <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                </div>
              
            </div>
            <div class="col-2">
              <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                  <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                </div>
              
            </div>
            <div class="col-2">
              <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                  <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                </div>
              </div>
            <div class="col-2">
              <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                  <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                </div>
              </div>
            <div class="col-2">
              <div class="card card-penulis mb-3" style="max-width: 540px; position: relative;">
                  <img src="{{ asset('storage/cover/cover_buku_1729563674.jpg') }}" 
                       class="img-fluid rounded-start" 
                       alt="..." 
                       style="height: 100%; width: 100%; object-fit: cover;">
                </div>
              </div>
              
            </div>
    </div>
</section>
@endsection