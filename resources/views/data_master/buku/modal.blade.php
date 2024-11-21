{{-- Tambah Buku --}}
<style>
    .text-danger1 {
        color: #dc3545;
    }
</style>
<div class="modal fade text-left" id="createBuku" tabindex="-1" role="dialog" aria-labelledby="modalCreate"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCreate">Tambah Buku</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" data-action="{{ route('crud_dm_buku') }}" method="POST" id="form_buku"
                    enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Cover <span class="text-danger1">*</span></label>
                                <input type="file" name="dbuku_cover" id="dbuku_cover" class="form-control">
                                <span id="cover-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Judul Buku <span class="text-danger1">*</span></label>
                                <input type="text" id="dbuku_judul" class="form-control" placeholder="Judul Buku"
                                    name="dbuku_judul">
                                <span id="judul-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label>link Buku <span class="text-danger1">*</span></label>
                            <input type="text" id="dbuku_link" class="form-control" placeholder="Link Buku"
                                name="dbuku_link">
                            <span id="link-error" class="text-danger"></span>
                        </div>
                        <div class="col-4 ">
                            <label for="dbuku_file">Ubah File PDF</label>
                            <input type="file" name="dbuku_file" id="dbuku_file" class="form-control">
                            <span id="file-error" class="text-danger"></span>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>ISBN <span class="text-danger1">*</span></label>
                                <input type="text" id="dbuku_isbn" class="form-control" placeholder="ISBN"
                                    name="dbuku_isbn" onkeypress="return hanyaAngka(event)">
                                <span id="isbn-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Penulis <span class="text-danger1">*</span></label>
                                @php
                                    $pnls = DB::select('SELECT * FROM dm_penulis');
                                @endphp
                                <select class="form-control" name="id_dpenulis">
                                    <option value="" selected disabled>Pilih Penulis</option>
                                    @foreach ($pnls as $item)
                                        <option value="{{ Crypt::encryptString($item->id_dpenulis) }}">
                                            {{ $item->dpenulis_nama_penulis }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="penulis-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Penerbit <span class="text-danger1">*</span></label>
                                @php
                                    $pnb = DB::select('SELECT * FROM dm_penerbits');
                                @endphp
                                <select class="form-control" name="id_dpenerbit">
                                    <option value="" selected disabled>Pilih Penerbit</option>
                                    @foreach ($pnb as $item)
                                        <option value="{{ Crypt::encryptString($item->id_dpenerbit) }}">
                                            {{ $item->dpenerbit_nama_penerbit }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="penerbit-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tahun Terbit <span class="text-danger1">*</span></label>
                                <select class="choices form-control" name="dbuku_thn_terbit">
                                    <option value="" selected disabled>Pilih Tahun Terbit</option>
                                    @php
                                        $tahunMulai = 2000;
                                        $tahunSekarang = date('Y');

                                        $opt_thn = '';
                                        for ($tahun = $tahunMulai; $tahun <= $tahunSekarang; $tahun++) {
                                            $opt_thn .= '<option value="' . $tahun . '">' . $tahun . '</option>';
                                        }
                                    @endphp
                                    {!! $opt_thn !!}
                                </select>
                                <span id="thn_terbit-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Lokasi Rak <span class="text-danger1">*</span></label>
                                <select class="form-control" name="dbuku_lokasi_rak">
                                    <option value="" selected disabled>Pilih Lokasi Rak</option>
                                    @php
                                        $lokasiRak = ['Rak A', 'Rak B', 'Rak C', 'Rak D', 'Rak E'];

                                        $opt_lok = '';
                                        foreach ($lokasiRak as $rak) {
                                            $opt_lok .= '<option value="' . $rak . '">' . $rak . '</option>';
                                        }
                                    @endphp
                                    {!! $opt_lok !!}
                                </select>
                                <span id="lokasi_rak-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Bahasa <span class="text-danger1">*</span></label>
                                <select class="form-control" name="dbuku_bahasa">
                                    <option value="" selected disabled>Pilih Bahasa</option>
                                    @php
                                        $bahasa = ['Indonesia', 'Inggris', 'Mandarin', 'Spanyol', 'Jepang'];

                                        $opt_bhs = '';
                                        foreach ($bahasa as $bhs) {
                                            $opt_bhs .= '<option value="' . $bhs . '">' . $bhs . '</option>';
                                        }
                                    @endphp
                                    {!! $opt_bhs !!}
                                </select>
                                <span id="bahasa-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Jumlah Buku <span class="text-danger1">*</span></label>
                                <input type="number" class="form-control" placeholder="Jumlah"
                                    name="dbuku_jml_total" min="0" max="100">
                                <span id="jml_total-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Edisi Buku <span class="text-danger1">*</span></label>
                                <select class="form-control" name="dbuku_edisi">
                                    <option value="" selected disabled>Pilih Edisi</option>
                                    @php
                                        $edisi = ['1', '2', '3', '3', '5', '6', '7', '8', '9', '10'];
                                        $opt_ed = '';
                                        foreach ($edisi as $ed) {
                                            $opt_ed .= '<option value="' . $ed . '">' . $ed . '</option>';
                                        }
                                    @endphp
                                    {!! $opt_ed !!}
                                </select>
                                <span id="edisi-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="Keterangan" class="text-danger1">-Jika buku ini tersedia untuk dibaca secara online, silakan unggah file atau tautan buku tersebut.
                                <br>-ISBN (International Standard Book Number).
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ml-1" id="store">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="edit" tabindex="1" role="dialog" aria-labelledby="modalEdit"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalEdit">Perbaharui Buku</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" id="form_buku_upd" method="PUT" enctype="multipart/form-data">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Cover Sebelumnya </label>
                                <img id="dbuku_cover" style="width: 150px; height: auto;">
                                <input type="hidden" id="id_bk" name="id_bk">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dbuku_cover">Ubah Cover <label for="" class="text-danger1"></label></label>
                            <input type="file" name="dbuku_cover" id="dbuku_cover" class="form-control">
                            <span id="cover-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label>Judul<label class="text-danger1">*</label></label>
                            <input type="text" id="dbuku_judul" class="form-control" placeholder="Judul Buku"
                                name="dbuku_judul">
                            <span id="judul-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label>link Buku</label>
                            <input type="text" id="dbuku_link" class="form-control" placeholder="Link Buku"
                                name="dbuku_link">
                            <span id="link-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dbuku_file">Ubah File PDF</label>
                            <input type="file" name="dbuku_file" id="dbuku_file" class="form-control">
                            <span id="file-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label>ISBN <label class="text-danger1">*</label></label>
                            <input type="text" id="dbuku_isbn" class="form-control" placeholder="ISBN"
                                name="dbuku_isbn" onkeypress="return hanyaAngka(event)">
                            <span id="isbn-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Penulis<label class="text-danger1">*</label></label>
                            <select class="form-control" name="id_dpenulis" id="id_penulis">
                                <option value="" selected disabled>Pilih Penulis</option>
                            </select>
                            <span id="penulis-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Penerbit<label class="text-danger1">*</label></label>
                            <select class="form-control" name="id_dpenerbit" id="id_penerbit">
                                <option value="" selected disabled>Pilih Penerbit</option>
                            </select>
                            <span id="penerbit-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tahun Terbit<label class="text-danger1">*</label></label>
                            <select class="choices form-control" name="dbuku_thn_terbit" id="dbuku_thn_terbit">
                                <option value="" selected disabled>Pilih Tahun Terbit</option>
                            </select>
                            <span id="thn_terbit-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Lokasi Rak<label class="text-danger1">*</label></label>
                            <select class="form-control" name="dbuku_lokasi_rak" id="dbuku_lokasi_rak">
                                <option value="" selected disabled>Pilih Lokasi Rak</option>
                            </select>
                            <span id="lokasi_rak-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Bahasa<label class="text-danger1">*</label></label>
                            <select class="form-control" name="dbuku_bahasa" id="dbuku_bahasa">
                                <option value="" selected disabled>Pilih Bahasa</option>
                            </select>
                            <span id="bahasa-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Jumlah Buku<label class="text-danger1">*</label></label>
                            <input type="number" name="dbuku_jml_total" class="form-control" placeholder="Jumlah"
                                id="dbuku_jml_total" min="0" max="100">
                            <span id="jml_total-error" class="text-danger"></span>
                            <span id="global-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Edisi Buku <label for="" class="text-danger1">*</label></label>
                            <select class="form-control" name="dbuku_edisi" id="dbuku_edisi">
                                <option value="" selected disabled>Pilih Edisi</option>
                            </select>
                            <span id="edisi-error" class="text-danger"></span>
                        </div>

                        <div class="col-12">
                            <label for="Keterangan" class="text-danger1">-Jika buku ini tersedia untuk dibaca secara online, silakan unggah file atau tautan buku tersebut.
                                <br>-ISBN (International Standard Book Number).
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade text-left" id="show" tabindex="-1" role="dialog" aria-labelledby="modalDelete"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalDelete">Detail Buku</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img id="dbuku_cover" alt="Book Cover"
                            style="width: 100%; height: 100%; object-fit: cover; object-position: center">
                    </div>
                    <div class="col-md-8">
                        <h2 id="dbuku_judul"></h2>
                        <b class="text-muted">ISBN: <label id="dbuku_isbn"></label></b>
                        <table class=" table-borderless table-sm mb-3 mt-2">
                            <tr>
                                <td>Penerbit</td>
                                <td>:</td>
                                <td id="id_penerbit"></td>
                            </tr>
                            <tr>
                                <td>Tahun Terbit</td>
                                <td>:</td>
                                <td id="dbuku_thn_terbit"></td>
                            </tr>
                            <tr>
                                <td>Lokasi Rak</td>
                                <td>:</td>
                                <td id="dbuku_lokasi_rak"></td>
                            </tr>
                            <tr>
                                <td>Bahasa</td>
                                <td>:</td>
                                <td id="dbuku_bahasa"></td>
                            </tr>
                            <tr>
                                <td>Jumlah Buku</td>
                                <td>:</td>
                                <td id="dbuku_jml_total"></td>
                            </tr>
                            <tr>
                                <td>Edisi Buku</td>
                                <td>:</td>
                                <td id="dbuku_edisi"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const kategoriSelect = document.querySelector('select[name="id_dkategori"]');
        //     const mapelSelect = document.querySelector('select[name="id_dmapel"]');

        //     kategoriSelect.addEventListener('change', function() {
        //         if (this.value === '1') {
        //             console.log(this.value)
        //             mapelSelect.disabled = false;
        //         } else {
        //             mapelSelect.value = '';
        //             mapelSelect.disabled = true;
        //         }
        //     });


        //     kategoriSelect.dispatchEvent(new Event('change'));
        // });
    </script>

    <script>
        function hanyaAngka(event) {
            var angka = (event.which) ? event.which : event.keyCode
            if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
                return false;
            return true;
        }
    </script>
