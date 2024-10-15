<!-- Modal untuk Edit Peminjaman -->
<div class="modal fade" id="editPeminjaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <!-- Header -->
            <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Peminjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form -->
            <form class="form" data-action="{{ route('peminjaman.update', ':id') }}" method="POST" id="form-edit-peminjaman">
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
                                        <select id="id_dbuku" name="id_dbuku" class="form-select shadow-sm rounded-pill">
                                            <option value="">Pilih Buku</option>
                                            @foreach ($buku as $data)
                                                <option value="{{ Crypt::encryptString($data->id_dbuku) }}">
                                                    {{ $data->dbuku_judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="buku-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Siswa -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_dsiswa">Nama Siswa</label>
                                        <select id="id_dsiswa" name="id_dsiswa" class="form-select shadow-sm rounded-pill">
                                            <option value="">Pilih Siswa</option>
                                            @foreach ($siswa as $data)
                                                <option value="{{ Crypt::encryptString($data->id_dsiswa) }}">
                                                    {{ $data->dsiswa_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="siswa-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Tanggal Peminjaman -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trks_tgl_peminjaman">Tanggal Peminjaman</label>
                                        <input type="date" id="trks_tgl_peminjaman" class="form-control shadow-sm rounded-pill" name="trks_tgl_peminjaman">
                                        <span id="tgl-pinjam-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Tanggal Jatuh Tempo -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trks_tgl_jatuh_tempo">Tanggal Jatuh Tempo</label>
                                        <input type="date" id="trks_tgl_jatuh_tempo" class="form-control shadow-sm rounded-pill" name="trks_tgl_jatuh_tempo">
                                        <span id="tgl-jatuh-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Tanggal Pengembalian -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trks_tgl_pengembalian">Tanggal Pengembalian</label>
                                        <input type="date" id="trks_tgl_pengembalian" class="form-control shadow-sm rounded-pill" name="trks_tgl_pengembalian">
                                        <span id="tgl-pengembalian-error" class="text-danger small"></span>
                                    </div>
                                </div>

                                <!-- Denda -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="trks_denda">Denda</label>
                                        <input type="numeric" id="trks_denda" class="form-control shadow-sm rounded-pill" placeholder="Masukkan Denda" name="trks_denda">
                                        <span id="denda-error" class="text-danger small"></span>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_status">Status</label>
                                            <select name="trks_status" id="trks_status" class="form-select rounded-pill" placeholder="Status">
                                                <option value="1">Dipinjam</option>
                                                <option value="2">Dikembalikan</option>
                                                <option value="3">Denda</option>
                                            </select>
                                        </div>
                                    </div>

                                <!-- Keterangan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="trks_keterangan">Keterangan</label>
                                        <input type="text" id="trks_keterangan" class="form-control shadow-sm rounded-pill" placeholder="Masukkan Keterangan" name="trks_keterangan">
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
                    <button type="submit" class="btn btn-primary rounded-pill">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
