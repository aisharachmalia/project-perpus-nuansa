@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-success mb-2 modalSimpanPenulis"
                                    data-bs-toggle="modal" data-bs-target="#tambahPenulis">+ Tambah</a>&nbsp;&nbsp;&nbsp;
                                <a href="javascript:;" class="btn btn-primary mb-2" id="export">Export
                                    Excel</a>&nbsp;&nbsp;&nbsp;
                                <a href="javascript:;" class="btn btn-danger mb-2" id="printout">Printout Pdf</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_penulis" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penulis</th>
                                    <th>Kewarganegaraan</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-success mb-2 modalSimpanPenerbit"
                                    data-bs-toggle="modal" data-bs-target="#tambahPenerbit">+ Tambah</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_penerbit" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penerbit</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-success mb-2 modalSimpanKategori"
                                    data-bs-toggle="modal" data-bs-target="#tambahKategori">+ Tambah</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_kategori" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal penulis --}}
    {{-- edit --}}
    <div class="modal fade text-left" id="editPenulis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Memperbarui Penulis</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_penulis">Nama Penulis</label>
                                            <input type="hidden" id="penulis_id" name="penulis_id">
                                            <input type="text" id="nama_penulis" class="form-control"
                                                placeholder="Nama Penulis" name="nama_penulis">
                                            <span class="text-danger" id="nama_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="kewarganegaraan">Kewarganegaraan</label>
                                            <input type="text" id="kewarganegaraan" class="form-control"
                                                placeholder="Kewarganegaraan" name="kewarganegaraan">
                                            <span class="text-danger" id="kewarganegaraan_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" id="tgl_lahir" class="form-control" name="tgl_lahir">
                                            <span class="text-danger" id="tgl_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="updatePenulis">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" id="submit">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- show --}}
    <div class="modal fade text-left" id="showPenulis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Melihat Penulis</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_penulis">Nama Penulis :</label>
                                            <input type="hidden" id="penulis_id" name="penulis_id">
                                            <p id="nama_penulis"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="kewarganegaraan">Kewarganegaraan :</label>
                                            <p id="kewarganegaraan"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="tgl_lahir">Tanggal Lahir :</label>
                                            <p id="tgl_lahir"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- create --}}
    <div class="modal fade text-left" id="tambahPenulis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Tambah Penulis</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_penulis">Nama Penulis</label>
                                            <input type="text" id="nama_penulis" class="form-control"
                                                placeholder="Nama Penulis" name="nama_penulis">
                                            <span class="text-danger" id="nama_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="kewarganegaraan">Kewarganegaraan</label>
                                            <input type="text" id="kewarganegaraan" class="form-control"
                                                placeholder="Kewarganegaraan" name="kewarganegaraan">
                                            <span class="text-danger" id="kewarganegaraan_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" id="tgl_lahir" class="form-control" name="tgl_lahir">
                                            <span class="text-danger" id="tgl_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="simpanPenulis">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- end modal penulis --}}

    {{-- Modal penerbit --}}
    {{-- edit --}}
    <div class="modal fade text-left" id="editPenerbit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Memperbarui Penerbit</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_penerbit">Nama Penerbit</label>
                                            <input type="hidden" id="penerbit_id">
                                            <input type="text" id="nama_penerbit" class="form-control"
                                                placeholder="Nama Penerbit" name="nama_penerbit">
                                            <span class="text-danger" id="nama_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" cols="10" rows="5" class="form-control" placeholder="Alamat"></textarea>
                                            <span class="text-danger" id="alamat_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="no_kontak">No Kontak</label>
                                            <input type="text" id="no_kontak" class="form-control" name="no_kontak"
                                                placeholder="No Kontak">
                                            <span class="text-danger" id="kontak_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="updatePenerbit">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" id="submit">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- show --}}
    <div class="modal fade text-left" id="showPenerbit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Melihat Penerbit</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_penulis">Nama Penerbit :</label>
                                            <input type="hidden" id="penerbit_id" name="penerbit_id">
                                            <p id="nama_penerbit"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="kewarganegaraan">Alamat :</label>
                                            <p id="alamat"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="no_kontak">Nomor Kontak :</label>
                                            <p id="no_kontak"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- create --}}
    <div class="modal fade text-left" id="tambahPenerbit" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Tambah Penerbit</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_penerbit">Nama Penerbit</label>
                                            <input type="text" id="nama_penerbit" class="form-control"
                                                placeholder="Nama Penerbit" name="nama_penerbit">
                                            <span class="text-danger" id="nama_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" cols="10" rows="5" class="form-control" placeholder="Alamat"></textarea>
                                            <span class="text-danger" id="alamat_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="no_kontak">No Kontak</label>
                                            <input type="text" id="no_kontak" class="form-control" name="no_kontak"
                                                placeholder="No Kontak">
                                            <span class="text-danger" id="kontak_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="simpanPenerbit">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- end modal penerbit --}}




    {{-- Modal kategori --}}
    {{-- edit --}}
    <div class="modal fade text-left" id="editKategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Memperbarui Kategori</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_penerbit">Nama Kategori</label>
                                            <input type="hidden" id="kategori_id">
                                            <input type="text" id="nama_kategori" class="form-control"
                                                placeholder="Nama Kategori">
                                            <span class="text-danger" id="nama_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="updateKategori">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" id="submit">Kirim</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- show --}}
    <div class="modal fade text-left" id="showKategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Melihat Kategori</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_penulis">Nama Kategori :</label>
                                            <input type="hidden" id="katgeori_id" name="penerbit_id">
                                            <p id="nama_kategori"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- create --}}
    <div class="modal fade text-left" id="tambahKategori" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Tambah Kategori</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="nama_penerbit">Nama Kategori</label>
                                        <input type="text" id="nama_kategori" class="form-control"
                                            placeholder="Nama Kategori" name="nama_penerbit">
                                        <span class="text-danger" id="nama_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="simpanKategori">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- end modal penerbit --}}
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var link_export = "{{ route('referensi.linkExport') }}";
            var link_print = "{{ route('referensi.linkPrintout') }}";
            var table = $('#tbl_penulis').DataTable({
                serverSide: true,
                ajax: '{{ url('/data-master/dpenulis') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'dpenulis_nama_penulis'
                    },
                    {
                        data: 'dpenulis_kewarganegaraan'
                    },
                    {
                        data: 'dpenulis_tgl_lahir'
                    },
                    {
                        data: 'aksi',
                        orderable: false
                    }
                ]
            });

            $(document).on('click', '#export', function() {
                var value_table = $('#tbl_penulis').DataTable().data().count();
                if (value_table > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: link_export,
                        dataType: 'json',
                        success: function(data) {
                            window.open(data.link, '_blank');
                        },
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        html: 'Tidak terdapat Data yang akan dicetak',
                        showCloseButton: true,
                        focusConfirm: false,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK',
                    });
                }
            });
            $(document).on('click', '#printout', function() {
                var value_table = $('#tbl_penulis').DataTable().data().count();
                if (value_table > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: link_print,
                        dataType: 'json',
                        success: function(data) {
                            window.open(data.link, '_blank');
                        },
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        html: 'Tidak terdapat Data yang akan dicetak',
                        showCloseButton: true,
                        focusConfirm: false,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK',
                    });
                }
            });

            var table = $('#tbl_penerbit').DataTable({
                serverSide: true,
                ajax: '{{ url('/data-master/dpenerbit') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'dpenerbit_nama_penerbit'
                    },
                    {
                        data: 'dpenerbit_alamat'
                    },
                    {
                        data: 'dpenerbit_no_kontak'
                    },
                    {
                        data: 'aksi',
                        orderable: false
                    }
                ]
            });
            var table = $('#tbl_kategori').DataTable({
                serverSide: true,
                ajax: '{{ url('/data-master/dkategori') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'dkategori_nama_kategori'
                    },
                    {
                        data: 'aksi',
                        orderable: false
                    }
                ]
            });
        });
    </script>

    {{-- js ajax penulis --}}
    <script>
        // ajax show
        $('body').on('click', '.modalShowPenulis', function() {

            let id_penulis = $(this).data('id');
            $.ajax({
                url: `penulis/show/${id_penulis}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#showPenulis').find('#nama_penulis').text(response.dpenulis_nama_penulis);
                    $('#showPenulis').find('#kewarganegaraan').text(response.dpenulis_kewarganegaraan);
                    $('#showPenulis').find('#tgl_lahir').text(response.dpenulis_tgl_lahir);
                }
            });
        });


        // ajax edit
        $('body').on('click', '.modalEditPenulis', function() {

            let id_penulis = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `penulis/show/${id_penulis}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);

                    //fill data to form
                    $('#editPenulis').find('#penulis_id').val(id_penulis);
                    $('#editPenulis').find('#nama_penulis').val(response.dpenulis_nama_penulis);
                    $('#editPenulis').find('#kewarganegaraan').val(response.dpenulis_kewarganegaraan);
                    $('#editPenulis').find('#tgl_lahir').val(response.dpenulis_tgl_lahir);

                    $('#tgl_error').text('');
                    $('#nama_error').text('');
                    $('#kewarganegaraan_error').text('');
                }
            });
        });

        //action update post
        $('#updatePenulis').click(function(e) {
            e.preventDefault();

            //define variable
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_penulis = $('#editPenulis').find('#penulis_id').val();;
            let dpenulis_nama = $('#editPenulis').find('#nama_penulis').val();
            let dpenulis_kewarganegaraan = $('#editPenulis').find('#kewarganegaraan').val();
            let dpenulis_tgl_lahir = $('#editPenulis').find('#tgl_lahir').val();
            //ajax
            $.ajax({
                url: `penulis/edit/${id_penulis}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama_penulis": dpenulis_nama,
                    "dpenulis_kewarganegaraan": dpenulis_kewarganegaraan,
                    "dpenulis_tgl_lahir": dpenulis_tgl_lahir,
                    "_token": token
                },
                success: function(response) {

                    //edit success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        editConfirmButton: false,
                        timer: 3000
                    });
                    $('#editPenulis').modal('toggle');
                    $('.modal-backdrop').remove();
                    $('#tbl_penulis').DataTable().ajax.reload();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        // Tampilkan pesan error dari validasi
                        if (errors.nama_penulis) {
                            $('#editPenulis').find('#nama_error').text(errors.nama_penulis[0]);
                        } else {
                            $('#editPenulis').find('#nama_error').text('');
                        }
                        if (errors.dpenulis_kewarganegaraan) {
                            $('#editPenulis').find('#kewarganegaraan_error').text(errors
                                .dpenulis_kewarganegaraan[0]);
                        } else {
                            $('#editPenulis').find('#kewarganegaraan_error').text('');
                        }
                        if (errors.dpenulis_tgl_lahir) {
                            $('#editPenulis').find('#tgl_error').text(errors.dpenulis_tgl_lahir[0]);
                        } else {
                            $('#editPenulis').find('#tgl_error').text('');
                        }
                    }
                }
            });
        });

        // ajax add
        $('body').on('click', '.modalSimpanPenulis', function() {
            $('#tambahPenulis').find('#tgl_error').text('');
            $('#tambahPenulis').find('#nama_error').text('');
            $('#tambahPenulis').find('#kewarganegaraan_error').text('');
        });
        $('#simpanPenulis').on('click', function(e) {
            e.preventDefault();
            let nama_penulis = $('#tambahPenulis').find('#nama_penulis').val();
            let kewarganegaraan = $('#tambahPenulis').find('#kewarganegaraan').val();
            let tgl_lahir = $('#tambahPenulis').find('#tgl_lahir').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `penulis/add`,
                type: "POST",
                cache: false,
                data: {
                    "dpenulis_nama_penulis": nama_penulis,
                    "dpenulis_kewarganegaraan": kewarganegaraan,
                    "dpenulis_tgl_lahir": tgl_lahir,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#tambahPenulis').modal('toggle');
                    $('.modal-backdrop').remove();
                    $('#tbl_penulis').DataTable().ajax.reload();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                    $('#tambahPenulis').find('#nama_penulis').val('');
                    $('#tambahPenulis').find('#kewarganegaraan').val('');
                    $('#tambahPenulis').find('#tgl_lahir').val('');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        // Tampilkan pesan error dari validasi
                        if (errors.dpenulis_nama_penulis) {
                            $('#tambahPenulis').find('#nama_error').text(errors.dpenulis_nama_penulis[
                                0]);
                        } else {
                            $('#tambahPenulis').find('#nama_error').text('');
                        }
                        if (errors.dpenulis_kewarganegaraan) {
                            $('#tambahPenulis').find('#kewarganegaraan_error').text(errors
                                .dpenulis_kewarganegaraan[0]);
                        } else {
                            $('#tambahPenulis').find('#kewarganegaraan_error').text('');
                        }
                        if (errors.dpenulis_tgl_lahir) {
                            $('#tambahPenulis').find('#tgl_error').text(errors.dpenulis_tgl_lahir[0]);
                        } else {
                            $('#tambahPenulis').find('#tgl_error').text('');
                        }
                    }
                }

            });
        });


        // ajax delete
        $('body').on('click', '#btn-delete-penulis', function() {

            let id_gr = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {

                    console.log('test');

                    //fetch to delete data
                    $.ajax({

                        url: `penulis/delete/${id_gr}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#tbl_penulis').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });
    </script>
    {{-- end ajax penulis --}}


    {{-- js ajax penerbit --}}
    <script>
        // ajax show
        $('body').on('click', '.modalShowPenerbit', function() {

            let id_penerbit = $(this).data('id');
            $.ajax({
                url: `penerbit/show/${id_penerbit}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);
                    $('#showPenerbit').find('#nama_penerbit').text(response.dpenerbit_nama_penerbit);
                    $('#showPenerbit').find('#alamat').text(response.dpenerbit_alamat);
                    $('#showPenerbit').find('#no_kontak').text(response.dpenerbit_no_kontak);
                }
            });
        });



        // ajax edit
        $('body').on('click', '.modalEditPenerbit', function() {

            let id_Penerbit = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `penerbit/show/${id_Penerbit}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);

                    //fill data to form
                    $('#editPenerbit').find('#penerbit_id').val(id_Penerbit);
                    $('#editPenerbit').find('#nama_penerbit').val(response.dpenerbit_nama_penerbit);
                    $('#editPenerbit').find('#alamat').val(response.dpenerbit_alamat);
                    $('#editPenerbit').find('#no_kontak').val(response.dpenerbit_no_kontak);

                    $('#editPenerbit').find('#kontak_error').text('');
                    $('#editPenerbit').find('#nama_error').text('');
                    $('#editPenerbit').find('#alamat_error').text('');
                }
            });
        });

        //action update post
        $('#updatePenerbit').click(function(e) {
            e.preventDefault();

            //define variable
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_penulis = $('#editPenerbit').find('#penerbit_id').val();;
            let nama_penerbit = $('#editPenerbit').find('#nama_penerbit').val();
            let alamat = $('#editPenerbit').find('#alamat').val();
            let no_kontak = $('#editPenerbit').find('#no_kontak').val();
            //ajax
            $.ajax({
                url: `penerbit/edit/${id_penulis}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama_penerbit": nama_penerbit,
                    "alamat": alamat,
                    "no_kontak": no_kontak,
                    "_token": token
                },
                success: function(response) {

                    //edit success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        editConfirmButton: false,
                        timer: 3000
                    });
                    $('#editPenerbit').modal('toggle');
                    $('.modal-backdrop').remove();
                    $('#tbl_penerbit').DataTable().ajax.reload();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        // Tampilkan pesan error dari validasi
                        if (errors.nama_penerbit) {
                            $('#editPenerbit').find('#nama_error').text(errors.nama_penerbit[0]);
                        } else {
                            $('#editPenerbit').find('#nama_error').text('');
                        }
                        if (errors.alamat) {
                            $('#editPenerbit').find('#alamat_error').text(errors.alamat[0]);
                        } else {
                            $('#editPenerbit').find('#alamat_error').text('');
                        }
                        if (errors.no_kontak) {
                            $('#editPenerbit').find('#kontak_error').text(errors.no_kontak[0]);
                        } else {
                            $('#editPenerbit').find('#kontak_error').text('');
                        }
                    }
                }
            });
        });

        // ajax add

        $('body').on('click', '.modalSimpanPenerbit', function() {
            $('#tambahPenerbit').find('#kontak_error').text('');
            $('#tambahPenerbit').find('#nama_error').text('');
            $('#tambahPenerbit').find('#alamat_error').text('');

            $('#tambahPenerbit').find('#nama_penerbit').val('');
            $('#tambahPenerbit').find('#alamat').val('');
            $('#tambahPenerbit').find('#no_kontak').val('');
        });
        $('#simpanPenerbit').on('click', function(e) {
            e.preventDefault();
            let nama_penerbit = $('#tambahPenerbit').find('#nama_penerbit').val();
            let alamat = $('#tambahPenerbit').find('#alamat').val();
            let no_kontak = $('#tambahPenerbit').find('#no_kontak').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `penerbit/add`,
                type: "POST",
                cache: false,
                data: {
                    "nama_penerbit": nama_penerbit,
                    "alamat": alamat,
                    "no_kontak": no_kontak,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#tambahPenerbit').modal('toggle');
                    $('.modal-backdrop').remove();
                    $('#tbl_penerbit').DataTable().ajax.reload();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        console.log(errors);
                        // Tampilkan pesan error dari validasi
                        if (errors.nama_penerbit) {
                            $('#tambahPenerbit').find('#nama_error').text(errors.nama_penerbit[0]);
                        } else {
                            $('#tambahPenerbit').find('#nama_error').text('');
                        }
                        if (errors.alamat) {
                            $('#tambahPenerbit').find('#alamat_error').text(errors.alamat[0]);
                        } else {
                            $('#tambahPenerbit').find('#alamat_error').text('');
                        }
                        if (errors.no_kontak) {
                            $('#tambahPenerbit').find('#kontak_error').text(errors.no_kontak[0]);
                        } else {
                            $('#tambahPenerbit').find('#kontak_error').text('');
                        }
                    }
                }

            });
        });


        // ajax delete
        $('body').on('click', '#btn-delete-penerbit', function() {

            let id_penerbit = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({

                        url: `penerbit/delete/${id_penerbit}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#tbl_penerbit').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });
    </script>
    {{-- end ajax penerbit --}}


    {{-- js ajax kategori --}}
    <script>
        // ajax show
        $('body').on('click', '.modalShowKategori', function() {

            let id_penerbit = $(this).data('id');
            $.ajax({
                url: `kategori/show/${id_penerbit}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#showKategori').find('#nama_kategori').text(response.dkategori_nama_kategori);
                }
            });
        });


        // ajax edit
        $('body').on('click', '.modalEditKategori', function() {

            let id = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `kategori/show/${id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);

                    //fill data to form
                    $('#editKategori').find('#kategori_id').val(id);
                    $('#editKategori').find('#nama_kategori').val(response.dkategori_nama_kategori);

                    $('#editKategori').find('#nama_error').text('');
                }
            });
        });

        //action update post
        $('#updateKategori').click(function(e) {
            e.preventDefault();

            //define variable
            let token = $('meta[name="csrf-token"]').attr('content');
            let id = $('#editKategori').find('#kategori_id').val();
            let nama_kategori = $('#editKategori').find('#nama_kategori').val();
            //ajax
            $.ajax({
                url: `kategori/edit/${id}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama_kategori": nama_kategori,
                    "_token": token
                },
                success: function(response) {

                    //edit success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        editConfirmButton: false,
                        timer: 3000
                    });
                    $('#editKategori').modal('toggle');
                    $('.modal-backdrop').remove();
                    $('#tbl_kategori').DataTable().ajax.reload();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        // Tampilkan pesan error dari validasi
                        if (errors.nama_kategori) {
                            $('#editKategori').find('#nama_error').text(errors.nama_kategori[0]);
                        } else {
                            $('#editKategori').find('#nama_error').text('');
                        }
                    }
                }
            });
        });

        // ajax add

        $('body').on('click', '.modalSimpanKategori', function() {
            $('#tambahKategori').find('#nama_error').text('');
            $('#tambahKategori').find('#nama_kategori').val('');
        });
        $('#simpanKategori').on('click', function(e) {
            e.preventDefault();
            let nama_kategori = $('#tambahKategori').find('#nama_kategori').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `kategori/add`,
                type: "POST",
                cache: false,
                data: {
                    "nama_kategori": nama_kategori,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#tambahKategori').modal('toggle');
                    $('.modal-backdrop').remove();
                    $('#tbl_kategori').DataTable().ajax.reload();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        if (errors.nama_kategori) {
                            $('#tambahKategori').find('#nama_error').text(errors.nama_kategori[0]);
                        } else {
                            $('#tambahKategori').find('#nama_error').text('');
                        }
                    }
                }

            });
        });


        // ajax delete
        $('body').on('click', '#btn-delete-kategori', function() {

            let id_penerbit = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({

                        url: `kategori/delete/${id_penerbit}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#tbl_kategori').DataTable().ajax.reload()
                        }
                    });
                }
            })
        });
    </script>
    {{-- end ajax kategori --}}
@endpush
