@extends('userz')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@section('content')
    <div class="container">
        <div class="col-10">
            <div class="card1">
                <div class="row">

                    <!-- Book Cover -->
                    <div class="col-md-6">
                        <img id="dbuku_cover" alt="Book Cover" src="/storage/cover/{{ $bk->dbuku_cover }}"
                            style="" class="image"
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
                <!-- Book Cover -->

            </div>
        </div>

        <button id="startReading" class="btn btn-primary">Mulai Baca</button>
    </div>

    <div id="readingCanvas" style="display:none;">
        <h2>Membaca: {{ $bk->dbuku_judul }}</h2>

        <!-- Kontrol PDF dengan gaya review -->
        <div class="controls">
            <button id="prevPage"><i class="fa fa-chevron-left"></i></button>
            <span>Page: <span id="pageNum"></span> / <span id="pageCount"></span></span>
            <button id="nextPage"><i class="fa fa-chevron-right"></i></button>
            <button id="zoomIn"><i class="fa fa-search-plus"></i></button>
            <button id="zoomOut"><i class="fa fa-search-minus"></i></button>
            <button id="fullscreen"><i class="fa fa-expand"></i></button>
            <button id="finishReading" class="btn btn-success">Selesai Baca</button>
        </div>

        <!-- Container untuk menampilkan PDF -->
        <div id="viewerContainer" class="pdf-review" >
            <canvas id="pdf-canvas"></canvas>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        var url = "{{ Storage::url('file/' . $bk->dbuku_file) }}";
        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.5;
        var canvas = document.getElementById('pdf-canvas');
        var ctx = canvas.getContext('2d');

        // Fungsi untuk render halaman PDF
        function renderPage(num) {
            pageRendering = true;

            // Ambil halaman PDF
            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport({
                    scale: scale
                });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

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

        // Fungsi render halaman berikutnya
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        // Next page
        document.getElementById('nextPage').addEventListener('click', function() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        });

        // Previous page
        document.getElementById('prevPage').addEventListener('click', function() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        });

        // Zoom In
        document.getElementById('zoomIn').addEventListener('click', function() {
            scale += 0.2;
            queueRenderPage(pageNum);
        });

        // Zoom Out
        document.getElementById('zoomOut').addEventListener('click', function() {
            if (scale > 0.5) {
                scale -= 0.2;
            }
            queueRenderPage(pageNum);
        });

        // Fullscreen
        document.getElementById('fullscreen').addEventListener('click', function() {
            if (canvas.requestFullscreen) {
                canvas.requestFullscreen();
                background.style.display = 'none';
            } else if (canvas.mozRequestFullScreen) {
                canvas.mozRequestFullScreen();
                background.style.display = 'none';
            } else if (canvas.webkitRequestFullscreen) {
                canvas.webkitRequestFullscreen();
                background.style.display = 'none';
            }
        });

        // Load PDF.js dan tampilkan halaman pertama
        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('pageCount').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        });

        // Tampilkan canvas baca saat tombol 'Mulai Baca' ditekan
        document.getElementById('startReading').addEventListener('click', function() {
            document.querySelector('.container').style.display = 'none'; // Sembunyikan detail buku
            document.getElementById('readingCanvas').style.display = 'block'; // Tampilkan canvas baca
        });

        // Selesai membaca
        document.getElementById('finishReading').addEventListener('click', function() {
            alert('Terima kasih telah membaca!');
            location.reload(); // Reset halaman setelah selesai membaca
        });
    </script>
@endpush
