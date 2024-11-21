<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nuansa Baca</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/logoNuansa1.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('user.css')
    @stack('css')
</head>

<body>
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
        <div id="readingCanvas" style="display:none;">
            <h2 class="text-center">Membaca: {{ $bk->dbuku_judul }}</h2>
            <div class="pdf-container" id="pdf-container"></div>
        </div>
        <button id="finishReading" class="btn btn-success mt-3 align-self-center" style="display:none;">Selesai
            Baca</button>
    @endsection
</body>

</html>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const url = "{{ Storage::url('file/' . $bk->dbuku_file) }}";

        function loadPDF() {
            pdfjsLib.getDocument(url).promise.then(pdfDoc => {
                for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                    pdfDoc.getPage(pageNum).then(page => {
                        const viewport = page.getViewport({
                            scale: 1.5
                        });
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

        document.getElementById('startReading').addEventListener('click', function() {
            const bookId = "{{ Crypt::encryptString($bk->id_dbuku) }}"; // ID buku terenkripsi

            fetch(`/start-reading/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (response.status === 401) {
                        // Jika status 401 (Unauthorized), tampilkan SweetAlert dan redirect ke login
                        Swal.fire({
                            title: 'Mohon Maaf!',
                            text: 'Anda harus login terlebih dahulu.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $.ajax({
                                url: "/login-usr", // URL ke halaman login
                                type: "GET", // Request metode
                                success: function() {
                                    window.location.href =
                                        "{{ route('login-usr') }}"; // Redirect setelah login berhasil
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Terjadi Kesalahan',
                                        text: 'Gagal mengarahkan ke halaman login.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        });
                        throw new Error('Unauthorized');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        // Sembunyikan tombol mulai baca
                        document.getElementById('startReading').style.display = 'none';
                        // Sembunyikan area baca sebelum tampilkan
                        document.querySelector('.container-baca').style.display = 'none';
                        // Tampilkan area membaca dan tombol selesai baca
                        document.getElementById('readingCanvas').style.display = 'block';
                        document.getElementById('finishReading').style.display = 'block';
                        loadPDF(); // Panggil fungsi untuk memuat PDF
                    } else if (data.status === 'error') {
                        Swal.fire({
                            title: 'Mohon Maaf!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.message !== 'Unauthorized') {
                        Swal.fire({
                            title: 'Terjadi Kesalahan!',
                            text: 'Terjadi kesalahan saat memulai membaca buku.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
        });

        // Event listener untuk tombol selesai baca
        document.getElementById('finishReading').addEventListener('click', function() {
            const bookId = "{{ Crypt::encryptString($bk->id_dbuku) }}"; // ID buku terenkripsi

            fetch(`/finish-reading/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (response.status === 401) {
                        // Jika status 401 (Unauthorized), tampilkan SweetAlert dan redirect ke login
                        Swal.fire({
                            title: 'Mohon Maaf!',
                            text: 'Anda harus login terlebih dahulu.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $.ajax({

                                url: "", // URL ke halaman login
                                type: "GET", // Request metode
                                success: function() {
                                    window.location.href =
                                        "{{ route('login-usr') }}"; // Redirect setelah login berhasil
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Terjadi Kesalahan',
                                        text: 'Gagal mengarahkan ke halaman login.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        });
                        throw new Error('Unauthorized'); // Hentikan eksekusi lebih lanjut
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terima Kasih',
                            text: 'Terimakasih telah membaca buku ini.',
                            showConfirmButton: false,
                            timer: 3000
                        })
                        document.getElementById('startReading').style.display = 'block';
                        // Sembunyikan tombol selesai baca dan area membaca
                        document.getElementById('finishReading').style.display = 'none';
                        document.getElementById('readingCanvas').style.display = 'none';
                        // Kembalikan ke tampilan awal
                        document.querySelector('.container-baca').style.display = 'block';
                    } else if (data.status === 'error') {
                        Swal.fire({
                            title: 'Mohon Maaf!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.message !== 'Unauthorized') {
                        Swal.fire({
                            title: 'Terjadi Kesalahan!',
                            text: 'Terjadi kesalahan saat menyelesaikan membaca buku.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
        });
    </script>
@endpush
