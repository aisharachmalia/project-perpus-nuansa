@extends('userz')
@section('content')
<style>
    .penulis-section {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }
    .books-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
    .book-item {
        text-align: center;
    }
    .book-item img {
        width: 50%;
        height: auto;
        border-radius: 5px;
    }
    .see-more {
        margin-top: 10px;
    }
</style>
<section class="hero">
    <div class="container2">
        <h1 class="aesthetic-title">Nuansa Baca </h1>
        <p>Selamat datang di Nuansa Baca! Temukan Dunia Pengetahuan</p>
    </div>
</section>
<h1 class="text-center mb-4">Penulis Favorit</h1>
<div class="containers my-4">
    <div class="row">
        @forelse($penulisFavorit as $penulis)
            <div class="col-md-12 penulis-section">
                <h2 class="text-primary">{{ $penulis->dpenulis_nama_penulis }}</h2>
                <p class="text-muted">Total Peminjaman: {{ $penulis->total_peminjaman }}</p>
                
                <div class="books-container" id="books-{{ $penulis->id_dpenulis }}">
                    @foreach($penulis->buku->take(6) as $buku)
                        <div class="book-item">
                            <a href="{{ route('document.detail', ['id' => $buku->id_dbuku]) }}">
                            <img src="{{ asset('storage/cover/' . $buku->dbuku_cover) }}" alt="{{ $buku->dbuku_judul }}">
                            </a>
                            <p class="fw-bold mt-2">{{ $buku->dbuku_judul }}</p>
                            <small class="text-muted">{{ $buku->dbuku_thn_terbit }}</small>
                        </div>
                    @endforeach
                </div>

                @if($penulis->buku->count() >= 6)
                    <button class="btn btn-outline-primary see-more" 
                            data-penulis-id="{{ $penulis->id_dpenulis }}" 
                            data-offset="6">
                        See More
                    </button>
                @endif
            </div>
        @empty
            <p class="text-center">Data kosong</p>
        @endforelse
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
    $('.see-more').on('click', function() {
        let button = $(this);
        let penulisId = button.data('penulis-id');
        let offset = button.data('offset');

        $.ajax({
            url: "{{ route('penulis.loadMoreBooksFav') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id_dpenulis: penulisId,
                offset: offset
            },
            success: function(data) {
                if (data.length > 0) {
                    let newBooksHTML = '';
                    data.forEach(function(buku) {
                        newBooksHTML += 
                            '<div class="book-item">' +
                            '<img src="{{ asset('storage/cover') }}/' + buku.dbuku_cover + '" alt="' + buku.dbuku_judul + '">' +
                            '<p class="fw-bold mt-2">' + buku.dbuku_judul + '</p>' +
                            '<small class="text-muted">' + buku.dbuku_thn_terbit + '</small>' +
                            '</div>';
                    });

                    // Tambahkan buku baru
                    $('#books-' + penulisId).append(newBooksHTML);
                    // Update offset dan sembunyikan tombol jika tidak ada lagi data
                    button.data('offset', offset + 6);
                    if (data.length < 6) {
                        button.hide();
                    }
                } else {
                    button.hide();
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

