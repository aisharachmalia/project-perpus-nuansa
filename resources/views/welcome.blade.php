@extends('userz')
@section('content')
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
    <section class="author">
        <div class="container5">
            <h1 class="penulis">Rekomendasi Buku</h1>
            <div class="row">
                <div class="col-4">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="https://images.ctfassets.net/usf1vwtuqyxm/6S51pK7uwnyhkS9Io9DsAn/320c162c5150f853b8d8568c4715dcef/English_Harry_Potter_7_Epub_9781781100264.jpg?w=914&q=70&fm=jpg" class="img-fluid rounded-start" alt="...">
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                              <h5 class="card-title">Card title</h5>
                              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="col-4">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/b468d093312907.5e6139cf2ab03.png" class="img-fluid rounded-start" alt="...">
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                              <h5 class="card-title">Card title</h5>
                              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="col-4">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="https://berita.99.co/wp-content/uploads/2022/10/kumpulan-novel-dilan.jpg" class="img-fluid rounded-start" alt="...">
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                              <h5 class="card-title">Card title</h5>
                              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
             <div class="row">
                <div class="col-4">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="https://hachette.imgix.net/books/9781474614399.jpg?auto=compress,format" class="img-fluid rounded-start" alt="...">
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                              <h5 class="card-title">Card title</h5>
                              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="col-4">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="https://0.academia-photos.com/attachment_thumbnails/62366143/mini_magick20200315-4967-ibzmuf.png?1584314950" class="img-fluid rounded-start" alt="...">
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                              <h5 class="card-title">Card title</h5>
                              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="col-4">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="https://cdn2.penguin.com.au/covers/original/9780241189450.jpg" class="img-fluid rounded-start" alt="...">
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                              <h5 class="card-title">Card title</h5>
                              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
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
