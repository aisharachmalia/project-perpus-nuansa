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

        <!-- Kontrol PDF Gaya Komiku -->
        <div class="controls text-center my-3">
            <button id="prevPage"><i class="fa fa-chevron-left"></i> Sebelumnya</button>
            <span>Halaman: <span id="pageNum"></span> / <span id="pageCount"></span></span>
            <button id="nextPage">Berikutnya <i class="fa fa-chevron-right"></i></button>
        </div>

        <!-- Kontrol PDF Gaya Komiku -->
        
        <!-- Container untuk menampilkan PDF -->
        <div id="viewerContainer" style="width: 100%; text-align: center;">
            <canvas id="pdf-canvas" style="border:1px solid #ddd; max-width: 100%;"></canvas>
        </div>

        <button id="finishReading" class="btn btn-success my-3">Selesai Baca</button>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        const url = "{{ Storage::url('file/' . $bk->dbuku_file) }}";
        // Tampilkan canvas baca saat tombol 'Mulai Baca' ditekan
        document.getElementById('startReading').addEventListener('click', function() {
            document.querySelector('.container-baca').style.display = 'none'; // Sembunyikan detail buku
            document.getElementById('readingCanvas').style.display = 'block'; // Tampilkan canvas baca
            this.style.display = 'none'; // Sembunyikan tombol 'Mulai Baca'
        });

        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.2;
        const canvas = document.getElementById('pdf-canvas');
        const ctx = canvas.getContext('2d');

        function renderPage(num) {
            pageRendering = true;

            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({
                    scale
                });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport
                };
                const renderTask = page.render(renderContext);

                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            document.getElementById('pageNum').textContent = num;
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        document.getElementById('nextPage').addEventListener('click', function() {
            if (pageNum < pdfDoc.numPages) {
                pageNum++;
                queueRenderPage(pageNum);
            }
        });

        document.getElementById('prevPage').addEventListener('click', function() {
            if (pageNum > 1) {
                pageNum--;
                queueRenderPage(pageNum);
            }
        });

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('pageCount').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        });

        document.getElementById('startReading').addEventListener('click', function() {
            document.querySelector('.container-baca').style.display = 'none';
            document.getElementById('readingCanvas').style.display = 'block';
        });

        document.getElementById('finishReading').addEventListener('click', function() {
            alert('Terima kasih telah membaca!');
            location.reload();
        });
    </script>
@endpush