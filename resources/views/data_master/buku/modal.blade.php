{{-- Tambah Buku --}}
<div class="modal fade text-left" id="createBuku" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCreate">Tambah Buku</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" data-action="{{ route('crud_dm_buku') }}" method="POST" id="form_buku" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Cover</label>
                                <input type="file" name="dbuku_cover" id="dbuku_cover" class="form-control">
                                <span id="cover-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Judul Buku</label>
                                <input type="text" id="dbuku_judul" class="form-control" placeholder="Judul Buku" name="dbuku_judul">
                                <span id="judul-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>ISBN</label>
                                <input type="text" id="dbuku_isbn" class="form-control" placeholder="ISBN" name="dbuku_isbn">
                                <span id="isbn-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Penulis</label>
                                @php
                                    $pnls = DB::select("SELECT * FROM dm_penulis");
                                @endphp
                                <select class="form-control" name="id_dpenulis">
                                    <option value="" selected disabled>Pilih Penulis</option>
                                    @foreach ($pnls as $item)
                                        <option value="{{ $item->id_dpenulis }}">{{ $item->dpenulis_nama_penulis }}</option>
                                    @endforeach 
                                </select>
                                <span id="penulis-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Penerbit</label>
                                @php
                                    $pnb = DB::select("SELECT * FROM dm_penerbits");
                                @endphp
                                <select class="form-control" name="id_dpenerbit">
                                    <option value="" selected disabled>Pilih Penerbit</option>
                                    @foreach ($pnb as $item)
                                        <option value="{{ $item->id_dpenerbit }}">{{ $item->dpenerbit_nama_penerbit }}</option>
                                    @endforeach
                                </select>
                                <span id="penerbit-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Kategori</label>
                                @php
                                    $ktr = DB::select("SELECT * FROM dm_kategoris");
                                @endphp
                                <select class="form-control" name="id_dkategori">
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    @foreach ($ktr as $item)
                                        <option value="{{ $item->id_dkategori }}">{{ $item->dkategori_nama_kategori}}</option>
                                    @endforeach
                                </select>
                                <span id="kategori-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                @php
                                    $mpl = DB::select("SELECT * FROM dm_mapels");
                                @endphp
                                <select class="form-control" name="id_dmapel">
                                    <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                    @foreach ($mpl as $item)
                                        <option value="{{ $item->id_mapel }}">{{ $item->dmapel_nama_mapel }}</option>
                                    @endforeach
                                </select>
                                <span id="mapel-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tahun Terbit</label>
                                <select class="form-control" name="dbuku_thn_terbit">
                                    <option value="" selected disabled>Pilih Tahun Terbit</option>
                                    @php
                                        $tahunMulai = 2000;
                                        $tahunSekarang = date("Y");
                                        
                                        $opt_thn = '';
                                        for ($tahun = $tahunMulai; $tahun <= $tahunSekarang; $tahun++) {
                                        $opt_thn .= '<option value="'.$tahun.'">'.$tahun.'</option>';
                                        }   
                                    @endphp
                                    {!! $opt_thn !!}
                                </select>
                                <span id="thn_terbit-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Lokasi Rak</label>
                                <select class="form-control" name="dbuku_lokasi_rak">
                                    <option value="" selected disabled>Pilih Lokasi Rak</option>
                                    @php
                                        $lokasiRak = ["Rak A", "Rak B", "Rak C", "Rak D", "Rak E"];

                                        $opt_lok = '';
                                        foreach ($lokasiRak as $rak) {
                                            $opt_lok .='<option value="'.$rak.'">'.$rak.'</option>';
                                        }   
                                    @endphp
                                    {!! $opt_lok !!}
                                </select>
                                <span id="lokasi_rak-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Bahasa</label>
                                <select class="form-control" name="dbuku_bahasa">
                                    <option value="" selected disabled>Pilih Bahasa</option>
                                    @php
                                        $bahasa = ["Indonesia", "Inggris", "Mandarin", "Spanyol", "Jepang"];

                                        $opt_bhs = '';
                                        foreach ($bahasa as $bhs) {
                                            $opt_bhs .= '<option value="'.$bhs.'">'.$bhs.'</option>';
                                        }   
                                    @endphp
                                    {!! $opt_bhs !!}
                                </select>
                                <span id="bahasa-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Jumlah Buku</label>
                                <input type="number" class="form-control" placeholder="Jumlah" name="dbuku_jml_total">
                                <span id="jml_total-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Edisi Buku</label>
                                <select class="form-control" name="dbuku_edisi">
                                    <option value="" selected disabled>Pilih Edisi</option>
                                    @php
                                        $edisi = ["1", "2", "3", "3", "5", "6", "7", "8", "9", "10"];
                                        $opt_ed = '';
                                        foreach ($edisi as $ed) {
                                            $opt_ed .= '<option value="'.$ed.'">'.$ed.'</option>';
                                        }   
                                    @endphp
                                    {!! $opt_ed !!}
                                </select>
                                <span id="edisi-error" class="text-danger"></span>
                            </div>
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

<div class="modal fade text-left" id="edit" tabindex="1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalEdit">Perbaharui Buku</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" id="form_buku_upd" method="PUT" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Cover Sebelumnya</label>
                            <img id="dbuku_cover" style="width: 150px; height: auto;" >
                            <input type="hidden" id="id_bk" name="id_bk">
                            <label for="dbuku_cover">Ubah Cover</label>
                            <input type="file" name="dbuku_cover" id="dbuku_cover" class="form-control">
                            <span id="cover-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Judul Buku</label>
                            <input type="text" id="dbuku_judul" class="form-control" placeholder="Judul Buku" name="dbuku_judul">
                            <span id="judul-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>ISBN</label>
                            <input type="text" id="dbuku_isbn" class="form-control" placeholder="ISBN" name="dbuku_isbn">
                            <span id="isbn-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Penulis</label>
                            <select class="form-control" name="id_dpenulis" id="id_penulis">
                                <option value="" selected disabled>Pilih Penulis</option>
                            </select>
                            <span id="penulis-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Penerbit</label>
                            <select class="form-control" name="id_dpenerbit" id="id_penerbit">
                                <option value="" selected disabled>Pilih Penerbit</option>
                            </select>
                            <span id="penerbit-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Kategori</label>
                            <select class="form-control" name="id_dkategori" id="id_kategori">
                                <option value="" selected disabled>Pilih Kategori</option>
                            </select>
                            <span id="kategori-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Mata Pelajaran</label>
                            <select class="form-control" name="id_dmapel" id="id_mapel">
                                <option value="" selected disabled>Pilih Mata Pelajaran</option>
                            </select>
                            <span id="mapel-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tahun Terbit</label>
                            <select class="form-control" name="dbuku_thn_terbit" id="dbuku_thn_terbit">
                                <option value="" selected disabled>Pilih Tahun Terbit</option>
                            </select>
                            <span id="thn_terbit-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Lokasi Rak</label>
                            <select class="form-control" name="dbuku_lokasi_rak" id="dbuku_lokasi_rak">
                                <option value="" selected disabled>Pilih Lokasi Rak</option>
                            </select>
                            <span id="lokasi_rak-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Bahasa</label>
                            <select class="form-control" name="dbuku_bahasa" id="dbuku_bahasa">
                                <option value="" selected disabled>Pilih Bahasa</option>
                            </select>
                            <span id="bahasa-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Jumlah Buku</label>
                            <input type="number" name="dbuku_jml_total" class="form-control" placeholder="Jumlah" id="dbuku_jml_total">
                            <span id="jml_total-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Edisi Buku</label>
                            <select class="form-control" name="dbuku_edisi" id="dbuku_edisi">
                                <option value="" selected disabled>Pilih Edisi</option>
                            </select>
                            <span id="edisi-error" class="text-danger"></span>
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


<div class="modal fade text-left" id="show" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalDelete">Detail Buku</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-start mb-4">
                    <div class="col-4">
                        <b>Cover</b> : <br>
                        <img id="dbuku_cover" width="200px" height="300px">
                    </div>
                    <div class="col-4">
                        <b>Judul</b> : <br>
                        <p id="dbuku_judul"></p>
                    </div>
                    <div class="col-4">
                        <b>Bahasa</b> : <br>
                        <p id="dbuku_bahasa"></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <b>ISBN</b> : <br>
                        <p id="dbuku_isbn"></p>
                    </div>
                    <div class="col-4">
                        <b>Nama penulis</b> : <br>
                        <p id="id_penulis"></p>
                    </div>
                    <div class="col-4">
                        <b>Nama Penerbit</b> : <br>
                        <p id="id_penerbit"></p>
                    </div>
                </div>
                <div class="row justify-content-start mt-4">
                    <div class="col-4">
                        <b>Nama Kategori</b> : <br>
                        <p id="id_kategori"></p>
                    </div>
                    <div class="col-4">
                        <b>Mata pelajaran</b> : <br>
                        <p id="id_mapel"></p>
                    </div>
                    <div class="col-4">
                        <b>Jumlah Buku</b> : <br>
                        <p id="dbuku_jml_tersedia"></p>
                    </div>
                </div>
                <div class="row justify-content-start mt-4">
                    <div class="col-4">
                        <b>Tahun Terbit</b> : <br>
                        <p id="dbuku_thn_terbit"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
