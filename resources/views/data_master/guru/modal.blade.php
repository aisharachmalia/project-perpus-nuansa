<div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCreate">Tambah Guru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" data-action="{{ route('data_master.guru.add') }}" method="POST">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Nama</label>
                                <input type="text" id="dguru_nama" class="form-control" placeholder="Nama" name="dguru_nama">
                                <span id="nama-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="last-name-column">NIP</label>
                                <input type="text" name="angka" id="dguru_nip" class="form-control" placeholder="NIP" onkeypress="return hanyaAngka(event)">
                                <span id="nip-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="city-column">E-mail</label>
                                <input type="text" id="dguru_email" class="form-control" placeholder="E-mail" name="dguru_email">
                                <span id="email-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">No Telpon</label>
                                <input type="text" class="form-control" placeholder="NO. Telpon" name="dguru_no_telp" id="dguru_no_telp">
                                <span id="telp-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="id_usr">Mata Pelajaran</label>
                                    @php
                                        $mpl = DB::table('dm_mapels')->get();    
                                    @endphp
                                    <select class="form-control" id="id_mapel" name="id_mapel" required>
                                        <option disabled value="0" selected>Pilih Mata Pelajaran</option>
                                        @foreach ($mpl as $item)
                                            <option value="{{ $item->id_mapel }}">{{ $item->dmapel_nama_mapel }}</option>
                                        @endforeach
                                    </select>
                                    <span id="mapel-error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mt-4">
                            <div class="form-group">
                                <label for="country-floating">Alamat</label>
                                <textarea class="form-control" id="dguru_alamat" name="dguru_alamat" rows="3" placeholder="Masukan alamat"></textarea>
                                <span id="alamat-error" class="text-danger"></span>
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

<!-- Edit Modal -->
<div class="modal fade text-left" id="edit" tabindex="1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalEdit">Perbaharui Guru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Nama</label>
                                <input type="hidden" id="id_dguru">
                                <input type="text" id="dguru_nama" class="form-control" placeholder="Nama" name="dguru_nama">
                                <span id="nama-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="last-name-column">NIP</label>
                                <input type="text" name="angka" id="dguru_nip" class="form-control" placeholder="NIP" onkeypress="return hanyaAngka(event)">
                                <span class="text-danger" id="nip-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="city-column">E-mail</label>
                                <input type="text" id="dguru_email" class="form-control" placeholder="E-mail" name="dguru_email">
                                <span class="text-danger" id="email-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">No Telpon</label>
                                <input type="text" class="form-control" placeholder="NO. Telpon" name="dguru_no_telp" id="dguru_no_telp">
                                <span class="text-danger" id="telp-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="id_usr">Mata Pelajaran</label>
                                    <select class="form-control" id="id_mapel" name="id_mapel" required>
                                        <option disabled selected value=""></option>

                                    </select>
                                    <span id="mapel-error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Status</label>
                                <select class="form-control" id="dguru_status" name="dguru_status">
                                    <option disabled value="1" selected>Pilih Status</option>
                                    <option value="1">aktif</option>
                                    <option value="0">tidak aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mt-4">
                            <div class="form-group">
                                <label for="country-floating">Alamat</label>
                                <textarea class="form-control" id="dguru_alamat" name="dguru_alamat" rows="3" placeholder="Masukan alamat"></textarea>
                                <span class="text-danger" id="alamat-error"></span>
                            </div>
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

<!-- Show Modal -->
<div class="modal fade text-left" id="show" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalDelete">Detail Guru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <b>Nama</b> : <br>
                        <p id="dguru_nama"></p>
                    </div>
                    <div class="col-4">
                        <b>NIP</b> : <br>
                        <p id="dguru_nip"></p>
                    </div>
                    <div class="col-4">
                        <b>E-mail</b> : <br>
                        <p id="dguru_email"></p>
                    </div>
                </div>
                <div class="row justify-content-start mt-4">
                    <div class="col-4">
                        <b>Telpon</b> : <br>
                        <p id="dguru_no_telp"></p>
                    </div>
                    <div class="col-4">
                        <b>Alamat</b> : <br>
                        <p id="dguru_alamat"></p>
                    </div>
                    <div class="col-4">
                        <b>Mata pelajaran</b> : <br>
                        <p id="dmapel_nama_mapel"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<script>
    function hanyaAngka(event) {
        var angka = (event.which) ? event.which : event.keyCode
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
        return true;
    }
</script>
