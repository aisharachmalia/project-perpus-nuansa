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
                    <div class="card-header text-center mb-3">Daftar Kelas</div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="tbl_list" width="100%">
                            <thead>
                                <tr>
                                    <th>ID Kelas</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>
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


    {{-- kelas --}}
    <!-- Modal Show Kelas -->
<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Show Kelas</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_nama_kelas">Nama Kelas</label>
                                        <p id="dkelas_nama_kelas"></p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_tingkat">Tingkat</label>
                                        <p id="dkelas_tingkat"></p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_jurusan">Jurusan</label>
                                        <p id="dkelas_jurusan"></p>
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

<!-- Modal Edit Kelas -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalEdit">Edit Kelas</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_nama_kelas">Nama Kelas</label>
                                        <input type="hidden" id="id_dkelas" name="id_dkelas">
                                        <input type="text" id="dkelas_nama_kelas" class="form-control" placeholder="Nama Kelas" name="dkelas_nama_kelas">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_tingkat">Tingkat</label>
                                        <input type="text" id="dkelas_tingkat" class="form-control" placeholder="Tingkat" name="dkelas_tingkat">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_jurusan">Jurusan</label>
                                        <input type="text" id="dkelas_jurusan" class="form-control" placeholder="Jurusan" name="dkelas_jurusan">
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
                <button type="submit" class="btn btn-primary ml-1" id="update">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var link_export = "{{ route('referensi.linkExport') }}";
            var link_print = "{{ route('referensi.linkPrintout') }}";
            var table = $('#tbl_penulis').DataTable({
                serverSide: true,
                scrollX: true,
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
                scrollX: true,
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
            var table = $('#tbl_list').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '{{ url('/data-master/kelas') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'dkelas_nama_kelas'
                    },
                    {
                        data: 'dkelas_tingkat'
                    },
                    {
                        data: 'dkelas_jurusan'
                    },
                    {  data: null,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="${row.id_dkelas}"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-primary me-1 show-btn" data-id="${row.id_dkelas}"><i class="bi bi-eye"></i></button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id_dkelas}"><i class="bi bi-trash"></i></button>
                        `;
                    }
                }
                ]
            });

    //         $(document).ready(function() {
    // // Inisialisasi DataTable
    //         var table = $('#tbl_list').DataTable({
    //             processing: true,
    //             serverSide: true,
    //             ajax: '{{ url()->current() }}',
    //             columns: [
    //                 { data: 'id_dkelas' },
    //                 { data: 'dkelas_nama_kelas' },
    //                 { data: 'dkelas_tingkat' },
    //                 { data: 'dkelas_jurusan' },
    //                 {  data: null,
    //                 render: function(data, type, row) {
    //                     return `
    //                         <button class="btn btn-sm btn-outline-info me-1 show-btn" data-id="${row.id_dkelas}"><i class="bx bx-eye"></i> Lihat</button>
    //                         <button class="btn btn-sm btn-outline-warning me-1 edit-btn" data-id="${row.id_dkelas}"><i class="bx bx-pencil"></i> Edit</button>
    //                         <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.id_dkelas}"><i class="bx bx-trash"></i> Hapus</button>
    //                     `;
    //                 }

    //                 }
    //             ]
    //         });
    //     });
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


   <script>

    // Fungsi untuk menampilkan modal Show
    $('#tbl_list').on('click', '.show-btn', function() {
        var id = $(this).data('id'); 
        $.ajax({
            url: `kelas-detail/${id}`,
            method: 'GET',
            success: function(response) {
                $('#show').find('#dkelas_nama_kelas').text(response.dkelas_nama_kelas);
                $('#show').find('#dkelas_tingkat').text(response.dkelas_tingkat);
                $('#show').find('#dkelas_jurusan').text(response.dkelas_jurusan);
                $('#show').modal('show');
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
            }
        });
    });

    // Fungsi untuk menampilkan modal Edit
    $('#tbl_list').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: `kelas-detail/${id}`,
            method: 'GET',
            success: function(response) {
                $('#edit').find('#id_dkelas').val(response.id_dkelas);  // Ambil id dengan benar
                $('#edit').find('#dkelas_nama_kelas').val(response.dkelas_nama_kelas);
                $('#edit').find('#dkelas_tingkat').val(response.dkelas_tingkat);
                $('#edit').find('#dkelas_jurusan').val(response.dkelas_jurusan);
                $('#edit').modal('show');  // Tampilkan modal edit
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
            }
        });
    });

    // Fungsi untuk mengupdate data
    $(document).on('click', '#update', function(e) {
        e.preventDefault();

        let id_dkelas = $('#edit').find('#id_dkelas').val();
        let dkelas_nama_kelas = $('#edit').find('#dkelas_nama_kelas').val();
        let dkelas_tingkat = $('#edit').find('#dkelas_tingkat').val();
        let dkelas_jurusan = $('#edit').find('#dkelas_jurusan').val();
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `kelas-update/${id_dkelas}`,  // Pastikan URL update benar
            type: "PUT",
            data: {
                "_token": token,
                "dkelas_nama_kelas": dkelas_nama_kelas,
                "dkelas_tingkat": dkelas_tingkat,
                "dkelas_jurusan": dkelas_jurusan
       },
       success: function(response) {
           Swal.fire({
               icon: 'success',
               title: `${response.message}`,
               showConfirmButton: false,
               timer: 1500
           });
           $('#tbl_list').DataTable().ajax.reload();
           $('#edit').modal('hide');
       },
       error: function(xhr) {
           Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan saat memperbarui data', 'error');
       }
   });
});



    // Fungsi untuk menghapus data
$('body').on('click', '.delete-btn', function() {
    let id_dkelas = $(this).data('id'); // Mengambil id_dkelas dari data-id tombol
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
            // Mengirim permintaan DELETE ke server
            $.ajax({
                url: `kelas/delete/${id_dkelas}`,  // Pastikan URL delete sesuai dengan route Anda
                type: "DELETE",
                data: {
                    "_token": token
                },
                success: function(response) {
                    // Menampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#tbl_list').DataTable().ajax.reload(); // Memperbarui tabel
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus data', 'error');
                }
            });
        }
    });
});
    </script>

@endpush
