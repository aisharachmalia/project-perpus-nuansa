<h1 style="text-align:center">{{ $title}}</h1>

    <table class="book-table">
        <tr>
            <!-- Book Cover Image on the Left -->
            <td class="cover-cell">
                <img src="{{ asset($bk[0]->dbuku_cover) }}" alt="Book Cover" class="cover" width="200px" height="250px" style="object-fit: cover;">
            </td>
            
            <!-- Description Section on the Right -->
            <td class="deskripsi">
                <h2>{{ $bk[0]->dbuku_judul }}</h2>
                <p><strong>ISBN:</strong> {{ $bk[0]->dbuku_isbn }}</p>
                <p><strong>Nama Penulis:</strong> {{ $bk[0]->dpenulis_nama_penulis }}</p>
                <p><strong>Nama Penerbit:</strong> {{ $bk[0]->dpenerbit_nama_penerbit }}</p>
                <p><strong>Tahun Terbit:</strong> {{ $bk[0]->dbuku_thn_terbit }}</p>
                <p><strong>Jumlah:</strong> {{ $bk[0]->dbuku_jml_total }}</p>
            </td>
        </tr>
    </table>

<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;justify-content:center">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="text-align: center" width="5%">No</th>
            <th style="text-align: center" width ="45%">No. Salinan</th>
            <th width="20%" style="text-align: center;">Kondisi</th>
            <th style="text-align: center;" width="30%">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salinan as $key => $item)
            <tr>
                <td style="text-align: center;background-color: #fefe76" width="5%">{{ $key + 1 }}</td>
                <td style="text-align: center;" width="45%">{{ $item->dsbuku_no_salinan }}</td>
                <td style="text-align: center;" width="20%">{{ $item->dsbuku_kondisi }}</td>
                <td style="text-align: center" width="30%">@if($item->dsbuku_status == 0) Tersedia @elseif($item->dsbuku_status == 1) Dipinjam @elseif($item->dsbuku_status == 2) Reservasi @endif</td>
            </tr>
        @endforeach
    </tbody>
</table>
