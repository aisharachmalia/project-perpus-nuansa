<style>
    .book-entry {
        display: flex;
        align-items: center; 
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        page-break-after: always;
    }

    .cover {
        width: 300px;
        height: auto;
        object-fit: cover;
        margin-right: 20px;
    }

    .deskripsi {
        flex: 1; 
        display: flex;
        flex-direction: column;
    }

    .deskripsi h2,
    .deskripsi p {
        margin: 5px 0;
    }
</style>

<h1 style="text-align: center;margin-bottom: 20px">Rekap Buku</h1>

@foreach ($buku as $item)
    <div class="book-entry">
        <!-- Book Cover Image on the Left -->
        <img src="{{ asset('storage/cover/' . $item->dbuku_cover) }}" alt="Book Cover" class="cover">
        
        <!-- Description Section on the Right -->
        <div class="deskripsi">
            <h2>{{ $item->dbuku_judul }}</h2>
            <p><strong>ISBN:</strong> {{ $item->dbuku_isbn }}</p>
            <p><strong>Nama Penulis:</strong> {{ $item->dpenulis_nama_penulis }}</p>
            <p><strong>Nama Penerbit:</strong> {{ $item->dpenerbit_nama_penerbit }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $item->dbuku_thn_terbit }}</p>
        </div>
    </div>
@endforeach
