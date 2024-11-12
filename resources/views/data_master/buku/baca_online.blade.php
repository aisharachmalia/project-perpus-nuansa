@extends('baca_onl')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .container-baca {
        margin-top: 70px;
        padding-top: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .card1 {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .image {
        width: 100%;
        max-width: 400px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        margin-bottom: 15px;
    }

    .controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin: 20px 0;
    }

    .controls button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 12px;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .controls button:hover {
        background-color: #0056b3;
    }

    .controls button i {
        font-size: 1.2rem;
    }

    .controls span {
        font-size: 1rem;
        font-weight: bold;
    }

    .pdf-review {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    #pdf-canvas {
        width: 100%;
        max-width: 900px;
        height: auto;
        margin: 0 auto;
        
    }

    #readingCanvas {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }


    #startReading,
    #finishReading {
        font-size: 1.2rem;
        font-weight: bold;
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 15px;
    }

    #startReading:hover,
    #finishReading:hover {
        background-color: #218838;
    }
</style>
    <div class="container-baca">
        <div class="col-10">
            <div class="card1">
                <div class="row">
                    <!-- Book Cover -->
                    <div class="col-md-6">
                        <img id="dbuku_cover" alt="Book Cover" src="/storage/cover/{{ $bk->dbuku_cover }}" class="image"
                            onerror="this.src='/storage/cover/default.jpg';">
                    </div>

                    <!-- Book Details -->
                    <div class="col-md-6 p-4">
                        <h2 id="dbuku_judul">{{ $bk->dbuku_judul }}</h2>
                        <b class="text-muted">ISBN: <label id="dbuku_isbn">{{ $bk->dbuku_isbn }}</label></b>
                        <table class="table-borderless table-sm mb-3 mt-2">
                            <tr>
                                <td>Penulis</td>
                                <td>:</td>
                                <td id="id_penulis">{{ $bk->dpenulis_nama_penulis }}</td>
                            </tr>
                            <tr>
                                <td>Penerbit</td>
                                <td>:</td>
                                <td id="id_penerbit">{{ $bk->dpenerbit_nama_penerbit }}</td>
                            </tr>
                            <tr>
                                <td>Tahun Terbit</td>
                                <td>:</td>
                                <td id="dbuku_thn_terbit">{{ $bk->dbuku_thn_terbit }}</td>
                            </tr>
                            <tr>
                                <td>Bahasa</td>
                                <td>:</td>
                                <td id="dbuku_bahasa">{{ $bk->dbuku_bahasa }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Buku</td>
                                <td>:</td>
                                <td id="dbuku_jml_total">{{ $bk->dbuku_jml_total }}</td>
                            </tr>
                            <tr>
                                <td>Edisi Buku</td>
                                <td>:</td>
                                <td id="dbuku_edisi">{{ $bk->dbuku_edisi }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <button id="startReading" class="btn btn-primary mt-3">Mulai Baca</button>
    </div>
<div id="readingCanvas" style="display:none;">
    <h2 class="text-center">Membaca: {{ $bk->dbuku_judul }}</h2>
    <div class="pdf-container" id="pdf-container"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
    const url = "{{ Storage::url('file/' . $bk->dbuku_file) }}";
    
    // Tampilkan semua halaman saat tombol 'Mulai Baca' ditekan
    document.getElementById('startReading').addEventListener('click', function() {
        document.querySelector('.container-baca').style.display = 'none'; // Sembunyikan detail buku
        document.getElementById('readingCanvas').style.display = 'block'; // Tampilkan area baca
        loadPDF();
    });

    function loadPDF() {
        pdfjsLib.getDocument(url).promise.then(pdfDoc => {
            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                pdfDoc.getPage(pageNum).then(page => {
                    const viewport = page.getViewport({ scale: 1.5 });
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
                    canvas.classList.add('pdf-page');
                    document.getElementById('pdf-container').appendChild(canvas);

                    const renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            }
        }).catch(error => {
            console.error("Error loading PDF:", error);
            alert("Gagal memuat PDF. Periksa URL atau file PDF.");
        });
    }
</script>
@endpush
