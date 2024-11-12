<style>
    .book-entry {
        width: 100%;
        margin-bottom: 20px;
        page-break-after: always;
    }

    .book-table {
        width: 100%;
        border-collapse: collapse; 
    }

    .cover-cell {
        width: 300px; 
        vertical-align: top; 
        padding-right: 10px; 
    }

    .cover {
        width: 300 px;
        height: auto;
        object-fit: cover;
    }

    .deskripsi h2,
    .deskripsi p {
        margin: 5px 0;
    }
</style>

<h1 style="text-align: center; margin-bottom: 20px">Rekap Buku</h1>

@foreach ($buku as $item)
    <div class="book-entry">
        <table class="book-table">
            <tr>
                <!-- Book Cover Image on the Left -->
                <td class="cover-cell">
                    <img src="{{ asset('storage/cover/' . $item->dbuku_cover) }}" alt="Book Cover" class="cover">
                </td>
                
                <!-- Description Section on the Right -->
                <td class="deskripsi">
                    <h2>{{ $item->dbuku_judul }}</h2>
                    <p><strong>ISBN:</strong> {{ $item->dbuku_isbn }}</p>
                    <p><strong>Nama Penulis:</strong> {{ $item->dpenulis_nama_penulis }}</p>
                    <p><strong>Nama Penerbit:</strong> {{ $item->dpenerbit_nama_penerbit }}</p>
                    <p><strong>Tahun Terbit:</strong> {{ $item->dbuku_thn_terbit }}</p>
                </td>
            </tr>
        </table>
    </div>
@endforeach


