<!-- Modal untuk Edit Peminjaman -->

<div class="modal fade" id="editPeminjaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <!-- Header -->
            <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Peminjaman</h5>
            </div>

            <!-- Form -->
            <form class="form" data-action="{{ route('transaksi.update', ':id') }}" method="POST"
                id="form-edit-peminjaman">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Card Body -->
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Buku -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_dbuku">Judul Buku</label>
                                        <input type="hidden" id="id_trks" name="id_trks">
                                        <select id="id_dbuku" name="id_dbuku"
                                            class="form-select shadow-sm rounded-pill">
                                            <option value="">Pilih Buku</option>
                                        </select>
                                        <span id="buku-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Siswa -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city-column">Nama Peminjam</label>
                                        <select id="id_dsiswa" name="id_dsiswa"
                                            class="form-select shadow-sm rounded-pill">
                                            <option value="">Pilih Peminjam</option>
                                        </select>
                                        <span id="siswa-error" class="text-danger"></span>
                                    </div>
                                </div>
                                {{-- pustakawan --}}
                                @if ($role->id_role < 3)
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city-column" class="fw-semibold">Nama Pustakawan</label>
                                            <select id="id_dpustakawan" name="id_dpustakawan"
                                                class="form-select shadow-sm rounded-pill">
                                                <option value="">Pilih Pustakawan</option>
                                            </select>
                                            <span id="pustakawan-error" class="text-danger small"></span>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="id_dpustakawan" id="id_dpustakawan"
                                        value="{{ \Crypt::encryptString(Auth::user()->id_usr) }}">
                                @endif

                                <!-- Tanggal Peminjaman -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="trks_tgl_peminjaman">Tanggal Peminjaman</label>
                                        <input type="date" id="trks_tgl_peminjaman"
                                            class="form-control shadow-sm rounded-pill" name="trks_tgl_peminjaman">
                                        <span id="tgl-pinjam-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Tanggal Jatuh Tempo -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="trks_tgl_jatuh_tempo">Tanggal Jatuh Tempo</label>
                                        <input type="date" id="trks_tgl_jatuh_tempo"
                                            class="form-control shadow-sm rounded-pill" name="trks_tgl_jatuh_tempo">
                                        <span id="tgl-jatuh-error" class="text-danger small"></span>
                                    </div>
                                </div>

                            </div> <!-- End of Row -->
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary rounded-pill" id="simpanTransaksi">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal untuk Edit Pengembalian -->
<div class="modal fade" id="editPengembalian" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <!-- Header -->
            <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Pengembalian</h5>
            </div>

            <!-- Form -->
            <form class="form" data-action="{{ route('transaksi.update', ':id') }}" method="POST"
                id="form-edit-peminjaman">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Card Body -->
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Buku -->
                                <div class="col-md-{{ $role->id_role < 3 ? '4' : '6' }}">
                                    <div class="form-group">
                                        <label for="id_dbuku">Judul Buku</label>
                                        <input type="hidden" id="id_trks" name="id_trks">
                                        <select id="id_dbuku" name="id_dbuku"
                                            class="form-select shadow-sm rounded-pill">
                                            <option value="">Pilih Buku</option>
                                        </select>
                                        <span id="buku-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Siswa -->
                                <div class="col-md-{{ $role->id_role < 3 ? '4' : '6' }}">
                                    <div class="form-group">
                                        <label for="city-column">Nama Peminjam</label>
                                        <select id="id_dsiswa" name="id_dsiswa"
                                            class="form-select shadow-sm rounded-pill">
                                            <option value="">Pilih Peminjam</option>
                                        </select>
                                        <span id="siswa-error" class="text-danger"></span>
                                    </div>
                                </div>

                                {{-- pustakawan --}}
                                @if ($role->id_role < 3)
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" class="fw-semibold">Nama Pustakawan</label>
                                            <select id="id_dpustakawan" name="id_dpustakawan"
                                                class="form-select shadow-sm rounded-pill">
                                                <option value="">Pilih Pustakawan</option>
                                            </select>
                                            <span id="pustakawan-error" class="text-danger small"></span>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="id_dpustakawan" id="id_dpustakawan"
                                        value="{{ \Crypt::encryptString(Auth::user()->id_usr) }}">
                                @endif

                                <!-- Tanggal Peminjaman -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trks_tgl_peminjaman">Tanggal Peminjaman</label>
                                        <input type="date" id="trks_tgl_peminjaman"
                                            class="form-control shadow-sm rounded-pill" name="trks_tgl_peminjaman">
                                        <span id="tgl-pinjam-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Tanggal Jatuh Tempo -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trks_tgl_jatuh_tempo">Tanggal Jatuh Tempo</label>
                                        <input type="date" id="trks_tgl_jatuh_tempo"
                                            class="form-control shadow-sm rounded-pill" name="trks_tgl_jatuh_tempo">
                                        <span id="tgl-jatuh-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Tanggal Pengembalian -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trks_tgl_pengembalian">Tanggal Pengembalian</label>
                                        <input type="date" id="trks_tgl_pengembalian"
                                            class="form-control shadow-sm rounded-pill" name="trks_tgl_pengembalian">
                                        <span id="tgl-pengembalian-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Denda -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="trks_denda">Denda</label>
                                        <input type="numeric" id="trks_denda"
                                            class="form-control shadow-sm rounded-pill" placeholder="Masukkan Denda"
                                            name="trks_denda">
                                        <span id="denda-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="trks_keterangan">Keterangan</label>
                                        <textarea id="trks_keterangan" class="form-control shadow-sm " placeholder="Masukkan Keterangan"
                                            name="trks_keterangan" rows="3"></textarea>
                                        <span id="keterangan-error" class="text-danger small"></span>
                                    </div>
                                </div>

                            </div> <!-- End of Row -->
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary rounded-pill" id="simpanTransaksi">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal untuk Edit Reservasi -->
<div class="modal fade" id="editReservasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <!-- Header -->
            <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Reservasi</h5>
            </div>

            <!-- Form -->
            <form class="form" data-action="{{ route('reservasi.update', ':id') }}" method="POST"
                id="form-edit-reservasi">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Card Body -->
                    <div class="card-content">
                        <div class="card-body">
                           <div class="row g-4">
                                <!-- Buku -->
                                <div class="col-md-{{ $role->id_role < 3 ? '4' : '6' }}">
                                    <div class="form-group">
                                        <label for="id_dsiswa">Judul Buku</label>
                                        <input type="hidden" id="id_trks" name="id_trks">
                                        <select id="id_dsiswa" name="id_dsiswa"
                                            class="form-select shadow-sm rounded-pill">
                                            <option value="">Pilih Buku</option>
                                        </select>
                                        <span id="buku-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Siswa -->
                                <div class="col-md-{{ $role->id_role < 3 ? '4' : '6' }}">
                                    <div class="form-group">
                                        <label for="city-column">Nama Peminjam</label>
                                        <select id="id_dsiswa" name="id_dsiswa"
                                            class="form-select shadow-sm rounded-pill">
                                            <option value="">Pilih Peminjam</option>
                                        </select>
                                        <span id="siswa-error" class="text-danger"></span>
                                    </div>
                                </div>

                                {{-- pustakawan --}}
                                @if ($role->id_role < 3)
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" class="fw-semibold">Nama Pustakawan</label>
                                            <select id="id_dpustakawan" name="id_dpustakawan"
                                                class="form-select shadow-sm rounded-pill">
                                                <option value="">Pilih Pustakawan</option>
                                            </select>
                                            <span id="pustakawan-error" class="text-danger small"></span>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="id_dpustakawan" id="id_dpustakawan"
                                        value="{{ \Crypt::encryptString(Auth::user()->id_usr) }}">
                                @endif

                                <!-- Tanggal Reservasi -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trsv_tgl_reservasi">Tanggal Reservasi</label>
                                        <input type="date" id="trsv_tgl_reservasi"
                                            class="form-control shadow-sm rounded-pill" name="trsv_tgl_reservasi">
                                        <span id="tgl-reservasi-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Tanggal Kadaluarsa -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trsv_tgl_kadaluarsa">Tanggal Kadaluarsa</label>
                                        <input type="date" id="trsv_tgl_kadaluarsa"
                                            class="form-control shadow-sm rounded-pill" name="trsv_tgl_kadaluarsa">
                                        <span id="tgl-kadaluarsa-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Tanggal Pengambilan -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trsv_tgl_pemberitahuan">Tanggal Pemberitahuan</label>
                                        <input type="date" id="trsv_tgl_pemberitahuan"
                                            class="form-control shadow-sm rounded-pill" name="trsv_tgl_pemberitahuan">
                                        <span id="tgl-pemberitahuan-error" class="text-danger small"></span>
                                    </div>
                                </div>

                            </div> <!-- End of Row -->
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary rounded-pill" id="simpanReservasi">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


