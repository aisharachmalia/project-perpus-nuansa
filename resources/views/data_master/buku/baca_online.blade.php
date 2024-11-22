<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nuansa Baca</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/logoNuansa1.ico') }}">
    @include('user.css')
    @stack('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .container-baca {
            margin-top: 70px;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container-baca {
    position: absolute; /* atau fixed, tergantung kebutuhan */
    top: 20px;
    left: 50%;
    transform: translateX(-50%); /* Untuk tengah secara horizontal */
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
            margin: auto;
            /* Tombol akan diposisikan di tengah */
            display: block;
            /* Mengaktifkan margin auto */
        }


        #startReading:hover,
        #finishReading:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    @extends('baca_onl')
    @section('content')
        <div class="container-baca">
            <div class="col-10">
                <div class="card1">
                    <div class="row">
                        <!-- Book Cover -->
                        <div class="col-md-6">
                            <img id="dbuku_cover" alt="Book Cover" src="/storage/cover/{{ $bk->dbuku_cover }}"
                                class="image" onerror="this.src='/storage/cover/default.jpg';">
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
        <br><br><br>
        <div id="readingCanvas" style="display:none;">
            <h2 class="text-center mt-5">Membaca: {{ $bk->dbuku_judul }}</h2>
            <div id="pdf-container"></div>
        </div>
        <button id="finishReading" class="btn btn-success mt-3 mb-3 text-center" style="display:none;">Selesai Baca</button>
    @endsection

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const url = "{{ Storage::url('file/' . $bk->dbuku_file) }}";

            function handlePDFDisplay() {
                pdfjsLib.getDocument(url).promise
                    .then(pdfDoc => {
                        for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                            pdfDoc.getPage(pageNum).then(page => {
                                const canvas = document.createElement('canvas');
                                const ctx = canvas.getContext('2d');
                                const viewport = page.getViewport({
                                    scale: 1.5
                                });

                                canvas.height = viewport.height;
                                canvas.width = viewport.width;
                                canvas.classList.add('pdf-page');

                                document.getElementById('pdf-container').appendChild(canvas);

                                page.render({
                                    canvasContext: ctx,
                                    viewport
                                });
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error loading PDF:", error);
                        Swal.fire("Gagal memuat PDF", "Periksa URL atau file PDF.", "error");
                    });
            }

            document.getElementById('startReading').addEventListener('click', () => {
                fetch(`/start-reading/${"{{ Crypt::encryptString($bk->id_dbuku) }}"}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            document.getElementById('startReading').style.display = 'none';
                            document.querySelector('.container-baca').style.display = 'none';
                            document.getElementById('readingCanvas').style.display = 'block';
                            document.getElementById('finishReading').style.display = 'block';
                            handlePDFDisplay();
                        } else {
                            Swal.fire("Error", data.message, "error");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });

            document.getElementById('finishReading').addEventListener('click', () => {
                fetch(`/finish-reading/${"{{ Crypt::encryptString($bk->id_dbuku) }}"}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire("Terima Kasih", "Terimakasih telah membaca buku ini.", "success");
                            document.getElementById('finishReading').style.display = 'none';
                            document.getElementById('readingCanvas').style.display = 'none';
                            document.querySelector('.container-baca').style.display = 'block';
                            document.getElementById('startReading').style.display = 'block';
                        } else {
                            Swal.fire("Error", data.message, "error");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        </script>
    @endpush
</body>

</html>
