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
                                <span id="dbuku_cover-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Judul Buku</label>
                                <input type="text" id="dbuku_judul" class="form-control" placeholder="Judul Buku" name="dbuku_judul">
                                <span id="dbuku_judul-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>ISBN</label>
                                <input type="text" id="dbuku_isbn" class="form-control" placeholder="ISBN" name="dbuku_isbn">
                                <span id="dbuku_isbn-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Penulis</label>
                                <select class="form-control" name="id_dpenulis">
                                    <option value="" selected disabled>Pilih Penulis</option>
                                    <option value="tes">tes</option>
                                </select>
                                <span id="dbuku_penulis-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Penerbit</label>
                                <select class="form-control" name="id_dpenerbit">
                                    <option value="" selected disabled>Pilih Penerbit</option>
                                    <option value="tes">tes</option>
                                </select>
                                <span id="dbuku_penerbit-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" name="id_dkategori">
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    <option value="tes">tes</option>
                                </select>
                                <span id="dbuku_kategori-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select class="form-control" name="id_dmapel">
                                    <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                    <option value="tes">tes</option>
                                </select>
                                <span id="dbuku_mapel-error" class="text-danger"></span>
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
                                <span id="dbuku_thn_terbit-error" class="text-danger"></span>
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
                                <span id="dbuku_lokasi_rak-error" class="text-danger"></span>
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
                                <span id="dbuku_bahasa-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Jumlah Buku</label>
                                <input type="number" class="form-control" placeholder="Jumlah" name="dbuku_jml_total">
                                <span id="dbuku_jml_total-error" class="text-danger"></span>
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