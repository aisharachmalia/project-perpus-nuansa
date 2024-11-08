@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-custom btn-primary mb-2 modalCreate"
                                    data-bs-toggle="modal" data-bs-target="#tambahPeminjaman">
                                    Peminjaman
                                </a>
                                &nbsp; &nbsp;
                                <a href="javascript:void(0)" class="btn btn-custom btn-warning mb-2 pengembalian"
                                    data-bs-toggle="modal" data-bs-target="#pengembalian">
                                    Pengembalian
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_transaksi" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Nama Peminjam</th>
                                    <th>Tanggal Peminjaman & Tanggal Jatuh Tempo</th>
                                    <th>Tanggal Pengembalian & Status Pengembalian </th>
                                    <th>Denda</th>
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
                                <a href="javascript:void(0)" class="btn btn-custom btn-primary mb-2 reservasi"
                                    data-bs-toggle="modal" data-bs-target="#reservasi">
                                    Reservasi
                                </a>
                                &nbsp; &nbsp;
                                <a href="javascript:void(0)" class="btn btn-custom btn-success mb-2 pengambilan"
                                    data-bs-toggle="modal" data-bs-target="#pengambilan">
                                    Pengambilan
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_reservasi" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Nama Peminjam</th>
                                    <th>Tanggal Reservasi & Tanggal Kadaluarsa</th>
                                    <th>Tanggal Pengambilan & Tanggal Pemberitahuan </th>
                                    <th>Status Reservasi </th>
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


    <!-- Modal untuk Tambah Peminjaman -->
    <div class="modal fade text-left" id="tambahPeminjaman" tabindex="-1" role="dialog" aria-labelledby="modalCreate1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content shadow-lg rounded-4 border-0"> <!-- Tambahkan shadow, rounded, border-0 -->
                <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                    <!-- Gradient background untuk header -->
                    <h4 class="modal-title fw-bold" id="modalCreate">Peminjaman Buku</h4>
                </div>
                <div class="modal-body">
                    <form class="form" data-action="{{ route('pinjam.store') }}" method="POST" id="pinjamanForm">
                        @csrf
                        <div class="row g-4"> <!-- Tambahkan gap untuk ruang antar kolom -->
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="first-name-column" class="fw-semibold">Judul Buku</label>
                                    <select id="id_dbuku" name="id_dbuku" class="form-control shadow-sm rounded-pill">
                                        <option value="">Pilih Buku</option>
                                        @foreach ($buku as $data)
                                            <option value="{{ Crypt::encryptString($data->id_dbuku) }}">
                                                {{ $data->dbuku_judul }}</option>
                                        @endforeach
                                    </select>
                                    <span id="buku-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="last-name-column" class="fw-semibold">Nama Peminjam</label>
                                    <select id="id_dsiswa" name="id_dsiswa" class="form-control shadow-sm rounded-pill">
                                        <option value="">Pilih Peminjam</option>
                                        @foreach ($siswa2 as $data)
                                            <option value="{{ Crypt::encryptString($data->id_usr) }}">
                                                {{ $data->usr_nama }}</option>
                                        @endforeach
                                    </select>
                                    <span id="siswa-error" class="text-danger small"></span>
                                </div>
                            </div>
                            @php
                                $role = App\Models\akses_usr::join('users', 'akses_usrs.id_usr', 'users.id_usr')
                                    ->where('users.id_usr', Auth::user()->id_usr)
                                    ->join('roles', 'akses_usrs.id_role', 'roles.id_role')
                                    ->first();
                            @endphp
                            @if ($role->id_role < 3)
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column" class="fw-semibold">Nama Pustakawan</label>
                                        <select id="id_dpustakawan" name="id_dpustakawan"
                                            class="form-control shadow-sm rounded-pill">
                                            <option value="">Pilih Pustakawan</option>
                                            @foreach ($pustakawan as $data)
                                                <option value="{{ Crypt::encryptString($data->id_dpustakawan) }}">
                                                    {{ $data->dpustakawan_nama }}</option>
                                            @endforeach
                                        </select>
                                        <span id="pustakawan-error" class="text-danger small"></span>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="id_dpustakawan" id="id_dpustakawan"
                                    value="{{ \Crypt::encryptString(Auth::user()->id_usr) }}">
                            @endif
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="country-floating" class="fw-semibold">Tanggal Peminjaman</label>
                                    <input type="date" class="form-control shadow-sm rounded-pill"
                                        placeholder="tanggal pinjam" name="trks_tgl_peminjaman" id="trks_tgl_peminjaman">
                                    <span id="tgl-pinjam-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="country-floating" class="fw-semibold">Tanggal Jatuh Tempo</label>
                                    <input type="date" class="form-control shadow-sm rounded-pill"
                                        placeholder="tanggal jatuh tempo" name="trks_tgl_jatuh_tempo"
                                        id="trks_tgl_jatuh_tempo">
                                    <span id="tgl-jatuh-tempo-error" class="text-danger small"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary rounded-pill" id="storePinjaman">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- end modal peminjaman --}}



    <!-- Modal untuk Tambah reservasi -->
    <div class="modal fade text-left" id="reservasi" tabindex="-1" role="dialog" aria-labelledby="modalCreate1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content shadow-lg rounded-4 border-0"> <!-- Tambahkan shadow, rounded, border-0 -->
                <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                    <!-- Gradient background untuk header -->
                    <h4 class="modal-title fw-bold" id="modalCreate">Reservasi Buku</h4>
                </div>
                <div class="modal-body">
                    <form class="form" data-action="{{ route('reservasi.store') }}" method="POST" id="reservasiForm">
                        @csrf
                        <div class="row g-4"> <!-- Tambahkan gap untuk ruang antar kolom -->
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="fw-semibold">Judul Buku</label>
                                    <select id="id_dbuku" name="id_dbuku" class="form-control shadow-sm rounded-pill">
                                        <option value="">Pilih Buku</option>
                                        @foreach ($bukuReservasi as $data)
                                            <option value="{{ Crypt::encryptString($data->id_dbuku) }}">
                                                {{ $data->dbuku_judul }}</option>
                                        @endforeach
                                    </select>
                                    <span id="buku-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="fw-semibold">Nama Peminjam</label>
                                    <select id="id_dsiswa" name="id_dsiswa" class="form-control shadow-sm rounded-pill">
                                        <option value="">Pilih Peminjam</option>
                                        @foreach ($siswa2 as $data)
                                            <option value="{{ Crypt::encryptString($data->id_usr) }}">
                                                {{ $data->usr_nama }}</option>
                                        @endforeach
                                    </select>
                                    <span id="siswa-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="fw-semibold">Tanggal Reservasi</label><br>
                                    <input type="date" class="form-control shadow-sm rounded-pill"
                                        name="trks_tgl_reservasi" id="trks_tgl_reservasi">
                                    <span id="tgl-reservasi-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="fw-semibold">Tanggal Kadaluarsa</label><br>
                                    <input type="date" class="form-control shadow-sm rounded-pill"
                                        placeholder="tanggal jatuh tempo" name="trsv_tgl_kadaluarsa"
                                        id="trsv_tgl_kadaluarsa">
                                    <span id="tgl-kadaluarsa-error" class="text-danger small"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary rounded-pill" id="storeReservasi">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Tambah pengambilan-->
    <div class="modal fade text-left" id="pengambilan" tabindex="-1" role="dialog" aria-labelledby="modalCreate1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content shadow-lg rounded-4 border-0"> <!-- Tambahkan shadow, rounded, border-0 -->
                <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                    <!-- Gradient background untuk header -->
                    <h4 class="modal-title fw-bold" id="modalCreate">Pengambilan Buku</h4>
                </div>
                <div class="modal-body">
                    <form class="form" data-action="{{ route('pengambilan.store') }}" method="POST"
                        id="pengambilanForm">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="fw-semibold">Nama Peminjam</label>
                                    <input type="hidden" id="id_trsv">
                                    <select id="id_dsiswa" name="id_dsiswa" class="form-control shadow-sm rounded-pill">
                                        <option value="">Pilih Peminjam</option>
                                        @foreach ($reservasi as $data)
                                            <option value="{{ Crypt::encryptString($data->id_usr) }}">
                                                {{ $data->usr_nama }}</option>
                                        @endforeach
                                    </select>
                                    <span id="siswa-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="fw-semibold">Judul Buku</label>
                                    <select id="id_dbuku" name="id_dbuku" class="form-control shadow-sm rounded-pill">
                                        <option value="">Pilih Buku</option>

                                    </select>
                                    <span id="buku-error" class="text-danger small"></span>
                                </div>
                            </div>
                            @if ($role->id_role < 3)
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" class="fw-semibold">Nama Pustakawan</label>
                                        <select id="id_dpustakawan" name="id_dpustakawan"
                                            class="form-control shadow-sm rounded-pill">
                                            <option value="">Pilih Pustakawan</option>
                                            @foreach ($pustakawan as $data)
                                                <option value="{{ Crypt::encryptString($data->id_dpustakawan) }}">
                                                    {{ $data->dpustakawan_nama }}</option>
                                            @endforeach
                                        </select>
                                        <span id="pustakawan-error" class="text-danger small"></span>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="id_dpustakawan" id="id_dpustakawan"
                                    value="{{ \Crypt::encryptString(Auth::user()->id_usr) }}">
                            @endif
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="fw-semibold">Tanggal Reservasi</label><br>
                                    <input type="date" class="form-control shadow-sm rounded-pill"
                                        name="trks_tgl_reservasi" id="trsv_tgl_reservasi">
                                    <span id="tgl-reservasi-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="fw-semibold">Tanggal Kadaluarsa</label><br>
                                    <input type="date" class="form-control shadow-sm rounded-pill"
                                        placeholder="tanggal jatuh tempo" name="trsv_tgl_kadaluarsa"
                                        id="trsv_tgl_kadaluarsa">
                                    <span id="tgl-kadaluarsa-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="country-floating" class="fw-semibold">Tanggal Pengambilan</label>
                                    <input type="date" class="form-control shadow-sm rounded-pill"
                                        placeholder="tanggal pengambilan" name="trsv_tgl_pengambilan"
                                        id="trsv_tgl_pengambilan">
                                    <span id="tgl-pengambilan-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="country-floating" class="fw-semibold">Tanggal Jatuh Tempo</label>
                                    <input type="date" class="form-control shadow-sm rounded-pill"
                                        placeholder="tanggal jatuh tempo" name="trsv_jatuh_tempo" id="trsv_jatuh_tempo">
                                    <span id="trsv-jatuh-tempo-error" class="text-danger small"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary rounded-pill" id="storePengambilan">Simpan</button>
                </div>
            </div>
        </div>
    </div>


    {{-- end modal reservasi --}}

    @include('transaksi.edit_trks')

    <!-- Modal untuk Pengembalian -->
    <div class="modal fade text-left" id="pengembalian" tabindex="-1" role="dialog"
        aria-labelledby="modalPengembalian">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalPengembalian">Pengembalian Buku</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="last-name-column">Nama Peminjam</label>
                                <input type="hidden" name="id_trks" id="id_trks">
                                <select id="id_dsiswa" name="id_dsiswa" class="form-control">
                                    <option value="">Pilih Peminjam</option>
                                    @foreach ($siswa as $data)
                                        <option value="{{ Crypt::encryptString($data->id_usr) }}">
                                            {{ $data->usr_nama }}</option>
                                    @endforeach
                                </select>
                                <span id="siswa-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Judul Buku</label>
                                <select id="id_dbuku" name="id_dbuku" class="form-control">
                                    <option value="">Pilih Buku</option>
                                </select>
                                <span id="buku-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Tanggal Peminjaman</label>
                                <input type="date" class="form-control" name="trks_tgl_peminjaman"
                                    id="trks_tgl_peminjaman">
                                <span id="tgl-pinjam-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Tanggal Jatuh Tempo</label>
                                <input type="date" class="form-control" name="trks_tgl_jatuh_tempo"
                                    id="trks_tgl_jatuh_tempo">
                                <span id="tgl-jatuh-tempo-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Tanggal Pengembalian</label>
                                <input type="date" class="form-control" name="trks_tgl_pengembalian"
                                    id="trks_tgl_pengembalian">
                                <span id="tgl-pengembalian-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Denda</label>
                                <input type="text" class="form-control" name="trks_denda" id="trks_denda"
                                    placeholder="Masukkan Denda">
                                <span id="denda-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="country-floating">Keterangan</label>
                                <textarea name="trks_keterangan" id="trks_keterangan" name="trks_keterangan" cols="10" rows="5"
                                    class="form-control" placeholder="Masukan keterangan"></textarea>
                                <span id="keterangan-error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-custom btn-primary ml-1" id="simpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>


    {{-- show reservasi --}}
    <div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Lihat Detail Reservasi
                    </h5>
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
                                            <label for="usr_nama">Nama Peminjam</label>
                                            <p id="usr_nama"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="usr_username">Buku</label>
                                            <p id="buku"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="usr_email">Tanggal Reservasi</label>
                                            <p id="tgl_reservasi"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="verified">Tanggal Kadaluarsa</label>
                                            <p id="tgl_kadaluarsa"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="verified">Tanggal Pemberitahuan</label>
                                            <p id="tgl_pemberitahuan"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="verified">Tanggal Pengambilan</label>
                                            <p id="tgl_pengambilan"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="basicSelect">Status Reservasi</label>
                                            <p id="status"></p>
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
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal pengembalian --}}
    {{-- end modal reservasi --}}
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#tbl_transaksi').DataTable({
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        class: "text-center",
                        data: 'dbuku_judul'
                    },
                    {
                        class: "text-center",
                        data: 'usr_nama',
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            return '<strong>' + new Date(row.trks_tgl_peminjaman)
                                .toLocaleDateString('id-ID') + '</strong><br>' +
                                new Date(row.trks_tgl_jatuh_tempo).toLocaleDateString('id-ID');
                        }

                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            let pengembalian = row.trks_tgl_pengembalian == null ?
                                'Belum dikembalikan' :
                                new Date(row.trks_tgl_pengembalian).toLocaleDateString('id-ID');
                            let status = '';
                            if (row.trks_status == -1) {
                                status = 'Dibatalkan';
                            }
                            if (row.trks_status == 0) {
                                status = 'Dipinjam';
                            }
                            if (row.trks_status == 1) {
                                status = 'Dikembalikan';
                            }
                            return pengembalian + '  <br>' + status;
                        }
                    },
                    {
                        class: "text-center",
                        data: 'trks_denda',
                        render: function(data) {
                            if (data == null) {
                                return '0';
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'aksi',
                        orderable: false
                    }
                ]
            });
            var table = $('#tbl_reservasi').DataTable({
                serverSide: true,
                ajax: '{{ route('reservasi-table') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        class: "text-center",
                        data: 'dbuku_judul'
                    },
                    {
                        class: "text-center",
                        data: 'usr_nama',
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            return '<strong>' + new Date(row.trsv_tgl_reservasi).toLocaleDateString(
                                    'id-ID') + '</strong><br>' +
                                new Date(row.trsv_tgl_kadaluarsa).toLocaleDateString('id-ID');
                        }

                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            let pemberitahuan = row.trsv_tgl_pemberitahuan == null ?
                                'Belum ada pemberitahuan' :
                                new Date(row.trsv_tgl_pemberitahuan).toLocaleDateString('id-ID');
                            let pengambilan = row.trsv_tgl_pengambilan == null ?
                                'Belum diambil' :
                                new Date(row.trsv_tgl_pengambilan).toLocaleDateString('id-ID');
                            return pengambilan + '<br>' + pemberitahuan;
                        }

                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            let status = '';
                            if (row.trsv_status == -1) {
                                status = 'Dibatalkan';
                            }
                            if (row.trsv_status == 0) {
                                status = 'Kadaluarsa';
                            }
                            if (row.trsv_status == 1) {
                                status = 'Aktif';
                            }
                            if (row.trsv_status == 2) {
                                status = 'Selesai';
                            }
                            return status;
                        }

                    },
                    {
                        data: 'aksi',
                        orderable: false
                    }
                ]
            });
        });
        // ajax buat pinjaman
        $('body').on('click', '.modalCreate', function() {
            $('#tambahPeminjaman').find('span').text('');
            $('#tambahPeminjaman').find('input, select').val('');
            $('#tambahPeminjaman').find('#trks_tgl_peminjaman').val(new Date()
                .toISOString().slice(0, 10));

        });

        $('body').on('click', '.pengembalian', function() {
            $('#pengembalian').find('span').text('');
            $('#pengembalian').find('input, select').val("");
            $('#pengembalian').find('#id_dbuku').empty();
            $('#pengembalian').find('#id_dbuku').append(
                '<option value="">Pilih Buku</option>');
        });

        $('#pengembalian').find('#id_dsiswa').on('change', function() {
            var id_usr = $(this).val();
            if (id_usr == '') {
                $('#pengembalian').find('input, select').val("");
                $('#pengembalian').find('#id_dbuku').empty();
                $('#pengembalian').find('#id_dbuku').append(
                    '<option value="">Pilih Buku</option>');
            } else {
                $.ajax({
                    url: `/transaksi/detail`,
                    type: 'GET',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id_usr": id_usr
                    },
                    success: function(response) {
                        $('#pengembalian').find('#trks_tgl_pengembalian').val(new Date()
                            .toISOString().slice(0, 10));
                        $('#pengembalian').find('#id_dbuku').empty();
                        $('#pengembalian').find('#id_dbuku').append(
                            '<option value="">Pilih Buku</option>');
                        $.each(response, function(index, value) {
                            $('#pengembalian').find('#id_dbuku').append(
                                '<option value="' + value.id_trks + '">' +
                                value.dbuku_judul + '</option>');
                        });
                    }
                });
            }

        });

        $('#pengembalian').find('#id_dbuku').on('change', function() {
            var id_trks = $(this).val();
            var tanggalKembali = $('#pengembalian').find('#trks_tgl_pengembalian').val();
            $.ajax({
                url: `/transaksi/detailBuku`,
                type: 'GET',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id_trks": id_trks,
                    "trks_tgl_pengembalian": tanggalKembali
                },
                success: function(response) {
                    $('#pengembalian').find('#trks_tgl_peminjaman').val(response['buku']
                        .trks_tgl_peminjaman.split(' ')[0]);
                    $('#pengembalian').find('#trks_tgl_jatuh_tempo').val(response['buku']
                        .trks_tgl_jatuh_tempo.split(' ')[0]);
                    $('#pengembalian').find('#trks_denda').val(response['denda']);
                    $('#pengembalian').find('#id_trks').val(id_trks);
                }
            });
        });

        $('#pengembalian').find('#simpan').on('click', function(e) {
            e.preventDefault();
            let id_usr = $('#pengembalian').find('#id_dsiswa').val();
            let token = $('meta[name="csrf-token"]').attr('content');
            let denda = $('#pengembalian').find('#trks_denda').val();
            let id_trks = $('#pengembalian').find('#id_trks').val();
            let keterangan = $('#pengembalian').find('#trks_keterangan').val();
            let buku = $('#pengembalian').find('#id_dbuku').val();
            let jatuh_tempo = $('#pengembalian').find('#trks_tgl_jatuh_tempo').val();
            let peminjaman = $('#pengembalian').find('#trks_tgl_peminjaman').val();
            let tanggal_pengembalian = $('#pengembalian').find('#trks_tgl_pengembalian').val();
            $.ajax({
                url: `/pengembalian`,
                type: "POST",
                cache: false,
                data: {
                    "_token": token,
                    "id_trks": id_trks,
                    "id_usr": id_usr,
                    "denda": denda,
                    "buku": buku,
                    "jatuh_tempo": jatuh_tempo,
                    "peminjaman": peminjaman,
                    "keterangan": keterangan,
                    "tanggal_pengembalian": tanggal_pengembalian
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pengembalian Berhasil',
                        html: `<p>${response.message}</p>`,
                        confirmButtonText: 'Ok',
                        timer: 3000,
                    });
                    $('#pengembalian').modal('toggle');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        // Tampilkan pesan error dari validasi
                        if (errors.id_usr) {
                            $('#pengembalian').find('#siswa-error').text(errors.id_usr[0]);
                        } else {
                            $('#pengembalian').find('#siswa-error').text('');
                        }

                        if (errors.buku) {
                            $('#pengembalian').find('#buku-error').text(errors.buku[0]);
                        } else {
                            $('#pengembalian').find('#buku-error').text('');
                        }


                        if (errors.peminjaman) {
                            $('#pengembalian').find('#tgl-pinjam-error').text(errors.peminjaman[0]);
                        } else {
                            $('#pengembalian').find('#tgl-pinjam-error').text('');
                        }


                        if (errors.tanggal_pengembalian) {
                            $('#pengembalian').find('#tgl-pengembalian-error').text(errors
                                .tanggal_pengembalian[0]);
                        } else {
                            $('#pengembalian').find('#tgl-pengembalian-error').text('');
                        }


                        if (errors.jatuh_tempo) {
                            $('#pengembalian').find('#tgl-jatuh-tempo-error').text(errors.jatuh_tempo[
                                0]);
                        } else {
                            $('#pengembalian').find('#tgl-jatuh-tempo-error').text('');
                        }


                        if (errors.keterangan) {
                            $('#pengembalian').find('#keterangan-error').text(errors
                                .keterangan[0]);
                        } else {
                            $('#pengembalian').find('#keterangan-error').text('');
                        }


                        if (errors.denda) {
                            $('#pengembalian').find('#denda-error').text(errors.denda[0]);
                        } else {
                            $('#pengembalian').find('#denda-error').text('');
                        }

                    }
                }
            });
        });

        $('#storePinjaman').off('click').on('click', function(e) {
            e.preventDefault();
            // Mendapatkan nilai dari input
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_dbuku = $('#pinjamanForm').find('#id_dbuku').val();
            let id_usr = $('#pinjamanForm').find('#id_dsiswa').val();
            let id_dpustakawan = $('#pinjamanForm').find('#id_dpustakawan').val();
            let trks_tgl_peminjaman = $('#pinjamanForm').find('#trks_tgl_peminjaman').val();
            let trks_tgl_jatuh_tempo = $('#pinjamanForm').find('#trks_tgl_jatuh_tempo').val();

            $.ajax({
                url: '/peminjaman/add',
                type: "POST",
                cache: false,
                data: {
                    "_token": token,
                    "id_dbuku": id_dbuku,
                    "id_usr": id_usr,
                    "id_dpustakawan": id_dpustakawan,
                    "trks_tgl_peminjaman": trks_tgl_peminjaman,
                    "trks_tgl_jatuh_tempo": trks_tgl_jatuh_tempo
                },
                success: function(response) {
                    if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Ok',
                            timer: 3000,
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Peminjaman Berhasil',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Ok',
                            timer: 3000,
                        });
                        $('#tambahPeminjaman').modal('toggle');
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        if (errors.id_dbuku) {
                            $('#tambahPeminjaman').find('#buku-error').text(errors.id_dbuku[0]);
                        } else {
                            $('#tambahPeminjaman').find('#buku-error').text('');
                        }

                        if (errors.id_usr) {
                            $('#tambahPeminjaman').find('#siswa-error').text(errors.id_usr[0]);
                        } else {
                            $('#tambahPeminjaman').find('#siswa-error').text('');
                        }

                        if (errors.id_dpustakawan) {
                            $('#tambahPeminjaman').find('#pustakawan-error').text(errors.id_dpustakawan[
                                0]);
                        } else {
                            $('#tambahPeminjaman').find('#pustakawan-error').text('');
                        }

                        if (errors.trks_tgl_peminjaman) {
                            $('#tambahPeminjaman').find('#tgl-pinjam-error').text(errors
                                .trks_tgl_peminjaman[0]);
                        } else {
                            $('#tambahPeminjaman').find('#tgl-pinjam-error').text('');
                        }

                        if (errors.trks_tgl_jatuh_tempo) {
                            $('#tambahPeminjaman').find('#tgl-jatuh-tempo-error').text(errors
                                .trks_tgl_jatuh_tempo[0]);
                        } else {
                            $('#tambahPeminjaman').find('#tgl-jatuh-tempo-error').text('');
                        }
                    }
                }
            });
        });

        // clear edit
        $('body').on('click', '.editPeminjaman', function() {
            $('#editPeminjaman').find('span').text('');
        });
        $('body').on('click', '.editPengembalian', function() {
            $('#editPengembalian').find('span').text('');
        });

        // AJAX Edit peminjaman
        $('body').on('click', '.editPeminjaman', function() {
            let id_trks = $(this).data('id');
            $.ajax({
                url: `transaksi/detail/update/${id_trks}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#editPeminjaman').find('#id_trks').val(id_trks);
                    $('#editPeminjaman').find('#id_dbuku').html(response['buku']);
                    $('#editPeminjaman').find('#id_dsiswa').html(response['usr']);
                    $('#editPeminjaman').find('#id_dpustakawan').html(response['pustakawan']);
                    $('#editPeminjaman').find('#trks_tgl_peminjaman').val(response['transaksi']
                        .trks_tgl_peminjaman.split(' ')[0]);
                    $('#editPeminjaman').find('#trks_tgl_jatuh_tempo').val(response['transaksi']
                        .trks_tgl_jatuh_tempo.split(' ')[0]);
                },
            });
        });
        $(document).on('click', '#simpanTransaksi', function(e) {
            e.preventDefault();
            let activeModal;
            if ($('#editPeminjaman').hasClass('show')) {
                activeModal = $('#editPeminjaman');
                type = 'peminjaman';
            } else if ($('#editPengembalian').hasClass('show')) {
                activeModal = $('#editPengembalian');
                type = 'pengembalian';
            }
            // Define variable
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_trks = activeModal.find('#id_trks').val();
            let id_dbuku = activeModal.find('#id_dbuku').val();
            let id_dpustakawan = activeModal.find('#id_dpustakawan').val();
            let id_usr = activeModal.find('#id_dsiswa').val();
            let trks_tgl_peminjaman = activeModal.find('#trks_tgl_peminjaman').val();
            let trks_tgl_jatuh_tempo = activeModal.find('#trks_tgl_jatuh_tempo').val();
            let trks_tgl_pengembalian = activeModal.find('#trks_tgl_pengembalian').val();
            let trks_denda = activeModal.find('#trks_denda').val();
            let trks_keterangan = activeModal.find('#trks_keterangan').val();


            // Clear error messages
            activeModal.find('span').text('');

            // Ajax
            $.ajax({
                url: `/transaksi/update/${id_trks}`,
                type: "PUT",
                cache: false,
                data: {
                    "id_dbuku": id_dbuku,
                    "id_usr": id_usr,
                    "id_dpustakawan": id_dpustakawan,
                    "trks_tgl_peminjaman": trks_tgl_peminjaman,
                    "trks_tgl_jatuh_tempo": trks_tgl_jatuh_tempo,
                    "trks_tgl_pengembalian": trks_tgl_pengembalian,
                    "trks_denda": trks_denda,
                    "trks_keterangan": trks_keterangan,
                    "type": type,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Transaksi Berhasil Dirubah',
                        html: `<p>${response.message}</p>`,
                        confirmButtonText: 'Ok',
                        timer: 3000,
                    });
                    activeModal.modal('toggle');
                    $('#tbl_transaksi').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = JSON.parse(xhr.responseText).errors;
                        // Show error messages for each field
                        if (errors.id_dbuku) {
                            activeModal.find('#buku-error').text(errors.id_dbuku[0]);
                        } else {
                            activeModal.find('#buku-error').text("");
                        }
                        if (errors.id_usr) {
                            activeModal.find('#siswa-error').text(errors.id_usr[0]);
                        } else {
                            activeModal.find('#siswa-error').text("");
                        }
                        if (errors.trks_tgl_peminjaman) {
                            activeModal.find('#tgl-pinjam-error').text(errors.trks_tgl_peminjaman[0]);
                        } else {
                            activeModal.find('#tgl-pinjam-error').text("");
                        }
                        if (errors.trks_tgl_jatuh_tempo) {
                            activeModal.find('#tgl-jatuh-error').text(errors.trks_tgl_jatuh_tempo[0]);
                        } else {
                            activeModal.find('#tgl-jatuh-error').text("");
                        }
                        if (errors.trks_tgl_pengembalian) {
                            activeModal.find('#tgl-pengembalian-error').text(errors
                                .trks_tgl_pengembalian[0]);
                        } else {
                            activeModal.find('#tgl-pengembalian-error').text("");
                        }
                        if (errors.trks_denda) {
                            activeModal.find('#denda-error').text(errors.trks_denda[0]);
                        } else {
                            activeModal.find('#denda-error').text("");
                        }
                        if (errors.trks_keterangan) {
                            activeModal.find('#keterangan-error').text(errors.trks_keterangan[0]);
                        } else {
                            activeModal.find('#keterangan-error').text("");
                        }

                    }
                }
            });
        });


        //Ajax edit pengembalian
        $('body').on('click', '.editPengembalian', function(e) {
            let id_trks = $(this).data('id');
            $.ajax({
                url: `transaksi/detail/update/${id_trks}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#editPengembalian').find('#id_trks').val(id_trks);
                    $('#editPengembalian').find('#id_dbuku').html(response['buku']);
                    $('#editPengembalian').find('#id_dsiswa').html(response['usr']);
                    $('#editPengembalian').find('#id_dpustakawan').html(response['pustakawan']);
                    $('#editPengembalian').find('#trks_tgl_peminjaman').val(response['transaksi']
                        .trks_tgl_peminjaman.split(' ')[0]);
                    $('#editPengembalian').find('#trks_tgl_jatuh_tempo').val(response['transaksi']
                        .trks_tgl_jatuh_tempo.split(' ')[0]);
                    $('#editPengembalian').find('#trks_tgl_pengembalian').val(response['transaksi']
                        .trks_tgl_pengembalian.split(' ')[0]);
                    $('#editPengembalian').find('#trks_denda').val(response['transaksi']
                        .trks_denda);
                },

            });
        })


        // ajax Create Reservasi
        $('#storeReservasi').off('click').on('click', function(e) {
            e.preventDefault();
            // Ambil nilai dari form
            let id_dbuku = $('#reservasi').find('#id_dbuku').val();
            let id_usr = $('#reservasi').find('#id_dsiswa').val();
            let trks_tgl_reservasi = $('#reservasi').find('#trks_tgl_reservasi').val();
            let trsv_tgl_kadaluarsa = $('#reservasi').find('#trsv_tgl_kadaluarsa').val();
            let token = $("meta[name='csrf-token']").attr("content");

            // Proses AJAX
            $.ajax({
                url: `reservasi/store`,
                type: "POST",
                cache: false,
                data: {
                    "id_dbuku": id_dbuku,
                    "id_usr": id_usr,
                    "trks_tgl_reservasi": trks_tgl_reservasi,
                    "trsv_tgl_kadaluarsa": trsv_tgl_kadaluarsa,
                    "_token": token
                },
                success: function(response) {
                    if (response.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Reservasi Berhasil',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Ok',
                            timer: 3000,
                        });
                        // Tutup modal dan reload DataTable
                        $('#reservasi').modal('toggle');
                        $('#tbl_reservasi').DataTable().ajax.reload();

                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Ada Buku Tersedia',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Tutup',
                            timer: 3000,
                        });
                        $('#reservasi').modal('toggle');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;

                        if (errors.id_dbuku) {
                            $('#reservasi').find('#buku-error').text(errors.id_dbuku[0]);
                        } else {
                            $('#reservasi').find('#buku-error').text('');
                        }

                        if (errors.id_usr) {
                            $('#reservasi').find('#siswa-error').text(errors.id_usr[0]);
                        } else {
                            $('#reservasi').find('#siswa-error').text('');
                        }

                        if (errors.trks_tgl_reservasi) {
                            $('#reservasi').find('#tgl-reservasi-error').text(errors.trks_tgl_reservasi[
                                0]);
                        } else {
                            $('#reservasi').find('#tgl-reservasi-error').text('');
                        }

                        if (errors.trsv_tgl_kadaluarsa) {
                            $('#reservasi').find('#tgl-kadaluarsa-error').text(errors
                                .trsv_tgl_kadaluarsa[0]);
                        } else {
                            $('#reservasi').find('#tgl-kadaluarsa-error').text('');
                        }

                    }
                }
            });
        });

        // show reservasi
        $('body').on('click', '.modalShow', function() {
            let id_trsv = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");
            //fetch detail post with ajax
            $.ajax({
                url: `/reservasi/detail`,
                type: "GET",
                cache: false,
                data: {
                    "id_trsv": id_trsv,
                    "type": 'show',
                    "_token": token
                },
                success: function(response) {
                    $('#show').find('#usr_nama').html(response.usr_nama);
                    $('#show').find('#buku').html(response.dbuku_judul);
                    $('#show').find('#tgl_reservasi').html(response.trsv_tgl_reservasi.split(' ')[0]);
                    $('#show').find('#tgl_kadaluarsa').html(response.trsv_tgl_kadaluarsa.split(' ')[0]);
                    $('#show').find('#tgl_pemberitahuan').html(response.trsv_tgl_pemberitahuan == null ?
                        "-" : response.trsv_tgl_pemberitahuan.split(' ')[0]);
                    $('#show').find('#tgl_pengambilan').html(response.trsv_tgl_pengambilan == null ?
                        "-" : response.trsv_tgl_pengambilan.split(' ')[0]);
                    if (response.trsv_status == -1) {
                        $('#show').find('#status').html(`Dibatalkan`);
                    } else if (response.trsv_status == 0) {
                        $('#show').find('#status').html(`Kadaluarsa`);
                    } else if (response.trsv_status == 1) {
                        $('#show').find('#status').html(`Aktif`);
                    } else {
                        $('#show').find('#status').html(`Selesai`);
                    };
                }
            });
        });

        // clear modal reservasi
        $('.pengambilan').on('click', function() {
            $('#pengambilan').find('input, select').val('');
            $('#pengambilan').find('span').text('');
            $('#pengambilan').find('#trsv_tgl_pengambilan').val(new Date().toISOString().slice(0, 10));

        });
        $('.reservasi').on('click', function() {
            $('#reservasi').find('input, select').val('');
            $('#reservasi').find('span').text('');
        });

        // reservasi ajax
        $('#pengambilan').find('#id_dsiswa').on('change', function() {
            let id_usr = $(this).val();
            let token = $("meta[name='csrf-token']").attr("content");
            if (id_usr == "") {
                $('#pengambilan').find('input, select').val('');
                $('#pengambilan').find('#trsv_tgl_pengambilan').val(new Date().toISOString().slice(0, 10));
                $('#pengambilan').find('#id_dbuku').empty();
                $('#pengambilan').find('#id_dbuku').append(
                    '<option value="">Pilih Buku</option>');
            } else {
                $.ajax({
                    url: `reservasi/detail`,
                    type: "GET",
                    cache: false,
                    data: {
                        "id_peminjam": id_usr,
                        'type': 'peminjam',
                        "_token": token
                    },
                    success: function(response) {
                        $('#pengambilan').find('#id_dbuku').empty();
                        $('#pengambilan').find('#id_dbuku').append(
                            '<option value="">Pilih Buku</option>');
                        $.each(response, function(index, value) {
                            $('#pengambilan').find('#id_dbuku').append(
                                '<option value="' + value.id_dbuku + '">' +
                                value.dbuku_judul + '</option>');
                        });
                    }
                });
            }

        });

        $('#pengambilan').find('#id_dbuku').on('change', function() {
            let id_dbuku = $(this).val();
            let token = $("meta[name='csrf-token']").attr("content");
            if (id_dbuku == '') {
                $('#pengambilan').find('#trsv_tgl_reservasi').val('');
                $('#pengambilan').find('#trsv_tgl_kadaluarsa').val('');
            } else {
                $.ajax({
                    url: `reservasi/detail`,
                    type: "GET",
                    cache: false,
                    data: {
                        "id_dbuku": id_dbuku,
                        'type': 'buku',
                        "_token": token
                    },
                    success: function(response) {
                        $('#pengambilan').find('#trsv_tgl_reservasi').val(response
                            .trsv_tgl_reservasi
                            .split(' ')[0]);
                        $('#pengambilan').find('#trsv_tgl_kadaluarsa').val(response
                            .trsv_tgl_kadaluarsa
                            .split(' ')[0]);
                        $('#pengambilan').find('#id_trsv').val(response.id_trsv);
                    }
                });
            }

        });
        // ajax Create Pengambilan
        $('#storePengambilan').off('click').on('click', function(e) {
            e.preventDefault();
            // Ambil nilai dari form
            let id_dbuku = $('#pengambilan').find('#id_dbuku').val();
            let id_usr = $('#pengambilan').find('#id_dsiswa').val();
            let trks_tgl_reservasi = $('#pengambilan').find('#trsv_tgl_reservasi').val();
            let trsv_tgl_kadaluarsa = $('#pengambilan').find('#trsv_tgl_kadaluarsa').val();
            let trsv_tgl_pengambilan = $('#pengambilan').find('#trsv_tgl_pengambilan').val();
            let trks_tgl_jth_tempo = $('#pengambilan').find('#trsv_jatuh_tempo').val();
            let id_trsv = $('#pengambilan').find('#id_trsv').val();
            let token = $("meta[name='csrf-token']").attr("content");
            // Proses AJAX
            $.ajax({
                url: `pengambilan/store`,
                type: "POST",
                cache: false,
                data: {
                    "id_dbuku": id_dbuku,
                    "id_trsv": id_trsv,
                    "id_dpustakawan": $('#pengambilan').find('#id_dpustakawan').val(),
                    "id_peminjam": id_usr,
                    "trks_tgl_reservasi": trks_tgl_reservasi,
                    "trks_tgl_jth_tempo": trks_tgl_jth_tempo,
                    "trsv_tgl_kadaluarsa": trsv_tgl_kadaluarsa,
                    "trsv_tgl_pengambilan": trsv_tgl_pengambilan,
                    "_token": token
                },
                success: function(response) {
                    if (response.status == 'error') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Buku Belum Tersedia untuk Pengambilan',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Ok',
                            timer: 3000,
                        });
                        $('#pengambilan').modal('toggle');
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pengambilan Buku Berhasil',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Ok',
                            timer: 3000,
                        });
                        $('#pengambilan').modal('toggle');
                        $('#tbl_reservasi').DataTable().ajax.reload();
                        $('#tbl_transaksi').DataTable().ajax.reload();
                    }


                    // Tutup modal dan reload DataTable
                    $('#pengambilan').modal('toggle');
                    $('#tbl_reservasi').DataTable().ajax.reload();
                    $('#tbl_transaksi').DataTable().ajax.reload();

                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        // Menampilkan pesan error di bawah input yang sesuai
                        if (errors.id_dbuku) {
                            $('#pengambilan').find('#buku-error').text(errors.id_dbuku[0]);
                        } else {
                            $('#pengambilan').find('#buku-error').text('');
                        }

                        if (errors.id_peminjam) {
                            $('#pengambilan').find('#siswa-error').text(errors.id_peminjam[0]);
                        } else {
                            $('#pengambilan').find('#siswa-error').text('');
                        }

                        if (errors.trks_tgl_reservasi) {
                            $('#pengambilan').find('#tgl-reservasi-error').text(errors
                                .trks_tgl_reservasi[0]);
                        } else {
                            $('#pengambilan').find('#tgl-reservasi-error').text('');
                        }

                        if (errors.trsv_tgl_kadaluarsa) {
                            $('#pengambilan').find('#tgl-kadaluarsa-error').text(errors
                                .trsv_tgl_kadaluarsa[0]);
                        } else {
                            $('#pengambilan').find('#tgl-kadaluarsa-error').text('');
                        }

                        if (errors.trks_tgl_pemberitahuan) {
                            $('#pengambilan').find('#tgl-pemberitahuan-error').text(errors
                                .trks_tgl_pemberitahuan[0]);
                        } else {
                            $('#pengambilan').find('#tgl-pemberitahuan-error').text('');
                        }

                        if (errors.trsv_tgl_pengambilan) {
                            $('#pengambilan').find('#tgl-pengambilan-error').text(errors
                                .trsv_tgl_pengambilan[0]);
                        } else {
                            $('#pengambilan').find('#tgl-pengambilan-error').text('');
                        }
                        if (errors.trks_tgl_jth_tempo) {
                            $('#pengambilan').find('#trsv-jatuh-tempo-error').text(errors
                                .trks_tgl_jth_tempo[0]);
                        } else {
                            $('#pengambilan').find('#trsv-jatuh-tempo-error').text('');
                        }
                        if (errors.id_dpustakawan) {
                            $('#pengambilan').find('#pustakawan-error').text(errors
                                .id_dpustakawan[0]);
                        } else {
                            $('#pengambilan').find('#pustakawan-error').text('');
                        }

                    }
                }
            });
        });
        $('body').on('click', '#btn-batal', function() {

            let id_trsv = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin membatalkan reservasi ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, BATALKAN!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/reservasi/batal`,
                        type: "POST",
                        cache: false,
                        data: {
                            "id_trsv": id_trsv,
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Reservasi Telah Dibatalkan',
                                html: `<p>${response.message}</p>`,
                                confirmButtonText: 'Ok',
                                timer: 3000,
                            });
                            $('#tbl_reservasi').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
<style>
    .swal2-html {
        font-size: 14px;
        /* Atur ukuran font */
        line-height: 1.5;
        /* Atur tinggi baris untuk spacing */
        max-width: 400px;
        /* Atur lebar maksimum */
        word-wrap: break-word;
        /* Memungkinkan teks panjang terputus */
    }

    .modal-content {
        background: linear-gradient(135deg, #f3f4f6, #e2e8f0);
        /* Gradasi warna lembut */
        border-radius: 12px;
        /* Membuat sudut modal melengkung */
        border: none;
        /* Menghilangkan border */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        /* Bayangan lembut */
    }

    .modal-header {
        border-bottom: 2px solid #cbd5e1;
        /* Garis bawah header */
    }

    .modal-title {
        color: #1f2937;
        /* Warna judul yang kontras */
        font-weight: bold;
        /* Membuat judul lebih menonjol */
    }

    .modal-body {
        padding: 20px;
        /* Ruang yang lebih besar untuk isi modal */
    }

    .form-control {
        border: 1px solid #cbd5e1;
        /* Border yang lebih halus */
        border-radius: 8px;
        /* Sudut input melengkung */
        transition: border-color 0.3s;
        /* Efek transisi border */
    }

    .form-control:focus {
        border-color: #3b82f6;
        /* Warna border saat fokus */
        box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
        /* Efek bayangan saat fokus */
    }

    .btn-custom {
        background-color: #3b82f6;
        /* Warna tombol */
        color: white;
        /* Warna teks tombol */
        border-radius: 8px;
        /* Sudut tombol melengkung */
        transition: background-color 0.3s;
        /* Efek transisi warna tombol */
    }

    .btn-custom:hover {
        background-color: #2563eb;
        /* Warna tombol saat hover */
    }
</style>
