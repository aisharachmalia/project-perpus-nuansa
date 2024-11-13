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
                                    <input type="datetime-local" class="form-control shadow-sm rounded-pill"
                                        placeholder="tanggal pinjam" name="trks_tgl_peminjaman"
                                        id="trks_tgl_peminjaman">
                                    <span id="tgl-pinjam-error" class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="country-floating" class="fw-semibold">Tanggal Jatuh Tempo</label>
                                    <input type="datetime-local" class="form-control shadow-sm rounded-pill"
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
                                <input type="datetime-local" class="form-control" name="trks_tgl_peminjaman"
                                    id="trks_tgl_peminjaman">
                                <span id="tgl-pinjam-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Tanggal Jatuh Tempo</label>
                                <input type="datetime-local" class="form-control" name="trks_tgl_jatuh_tempo"
                                    id="trks_tgl_jatuh_tempo">
                                <span id="tgl-jatuh-tempo-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Tanggal Pengembalian</label>
                                <input type="datetime-local" class="form-control" name="trks_tgl_pengembalian"
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
    {{-- end Modal Pengembalian --}}
