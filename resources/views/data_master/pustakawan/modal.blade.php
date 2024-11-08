<div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCreate">Tambahkan Data Pustakawan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" data-action="{{ route('data_master.pustakawan.add') }}" method="POST">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Nama</label>
                                <input type="text" id="dpustakawan_nama" class="form-control" placeholder="Nama" name="dpustakawan_nama">
                                <span id="nama-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="city-column">E-mail</label>
                                <input type="text" id="dpustakawan_email" class="form-control" placeholder="E-mail" name="dpustakawan_email">
                                <span id="email-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">No. Telepon</label>
                                <input type="text" class="form-control" placeholder="No.Telepon" name="dpustakawan_no_telp" id="dpustakawan_no_telp">
                                <span id="telp-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mt-4">
                            <div class="form-group">
                                <label for="country-floating">Alamat</label>
                                <textarea class="form-control" id="dpustakawan_alamat" name="dpustakawan_alamat" rows="3"></textarea>
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
                <h4 class="modal-title" id="modalEdit">Perbaharui Data Pustakawan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Nama</label>
                                <input type="hidden" id="id_dpustakawan">
                                <input type="text" id="dpustakawan_nama" class="form-control" placeholder="Nama" name="dpustakawan_nama">
                                <span id="nama-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="city-column">E-mail</label>
                                <input type="text" id="dpustakawan_email" class="form-control" placeholder="E-mail" name="dpustakawan_email">
                                <span class="text-danger" id="email-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">No. Telepon</label>
                                <input type="text" class="form-control" placeholder="No. Telepon" name="dpustakawan_no_telp" id="dpustakawan_no_telp">
                                <span class="text-danger" id="telp-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Status</label>
                                <br>
                                <input type="radio" name="dpustakawan_status" value="1" {{ old('dpustakawan_status') == 1 ? 'checked' : '' }}> Aktif
                                &nbsp;
                                <input type="radio" name="dpustakawan_status" value="0" {{ old('dpustakawan_status') == 0 ? 'checked' : '' }}> Tidak Aktif                                
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mt-4">
                            <div class="form-group">
                                <label for="country-floating">Alamat</label>
                                <textarea class="form-control" id="dpustakawan_alamat" name="dpustakawan_alamat" rows="3"></textarea>
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

<div class="modal fade text-left" id="show" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalDelete">Detail Data Pustakawan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <b>Nama</b> : <br>
                        <p id="dpustakawan_nama"></p>
                    </div>
                    <div class="col-4">
                        <b>E-mail</b> : <br>
                        <p id="dpustakawan_email"></p>
                    </div>
                    <div class="col-4">
                        <b>No. Telepon</b> : <br>
                        <p id="dpustakawan_no_telp"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <b>Alamat</b> : <br>
                        <p id="dpustakawan_alamat"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
{{-- SHOW --}}
