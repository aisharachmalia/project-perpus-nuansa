     <!-- Modal untuk Tambah reservasi -->
     <div class="modal fade text-left" id="reservasi" tabindex="-1" role="dialog" aria-labelledby="modalCreate1">
         <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
             <div class="modal-content shadow-lg rounded-4 border-0"> <!-- Tambahkan shadow, rounded, border-0 -->
                 <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                     <!-- Gradient background untuk header -->
                     <h4 class="modal-title fw-bold" id="modalCreate">Reservasi Buku</h4>
                 </div>
                 <div class="modal-body">
                     <form class="form" data-action="{{ route('reservasi.store') }}" method="POST"
                         id="reservasiForm">
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
                                     <select id="id_dsiswa" name="id_dsiswa"
                                         class="form-control shadow-sm rounded-pill">
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
                                     <input type="datetime-local" class="form-control shadow-sm rounded-pill"
                                         name="trks_tgl_reservasi" id="trks_tgl_reservasi">
                                     <span id="tgl-reservasi-error" class="text-danger small"></span>
                                 </div>
                             </div>
                             <div class="col-md-4 col-12">
                                 <div class="form-group">
                                     <label class="fw-semibold">Tanggal Kadaluarsa</label><br>
                                     <input type="datetime-local" class="form-control shadow-sm rounded-pill"
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
     {{-- End Modal Reservasi --}}

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
                         @if ($role->id_role == 3)
                                    @php
                                        $id_pustakawan = \Crypt::encryptString(Auth::user()->id_usr);
                                    @endphp
                                    <input type="hidden" name="id_dpustakawan" id="id_dpustakawan"
                                        value="{{ $id_pustakawan }}">
                                @endif
                         <div class="row g-4">
                             <div class="col-md-4 col-12">
                                 <div class="form-group">
                                     <label class="fw-semibold">Nama Peminjam</label>
                                     <input type="hidden" id="id_trsv">
                                     <select id="id_dsiswa" name="id_dsiswa"
                                         class="form-control shadow-sm rounded-pill">
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
                             @endif
                             <div class="col-md-4 col-12">
                                 <div class="form-group">
                                     <label class="fw-semibold">Tanggal Reservasi</label><br>
                                     <input type="datetime-local" class="form-control shadow-sm rounded-pill"
                                         name="trks_tgl_reservasi" id="trsv_tgl_reservasi">
                                     <span id="tgl-reservasi-error" class="text-danger small"></span>
                                 </div>
                             </div>
                             <div class="col-md-4 col-12">
                                 <div class="form-group">
                                     <label class="fw-semibold">Tanggal Kadaluarsa</label><br>
                                     <input type="datetime-local" class="form-control shadow-sm rounded-pill"
                                         placeholder="tanggal jatuh tempo" name="trsv_tgl_kadaluarsa"
                                         id="trsv_tgl_kadaluarsa">
                                     <span id="tgl-kadaluarsa-error" class="text-danger small"></span>
                                 </div>
                             </div>
                             <div class="col-md-4 col-12">
                                 <div class="form-group">
                                     <label for="country-floating" class="fw-semibold">Tanggal Pengambilan</label>
                                     <input type="datetime-local" class="form-control shadow-sm rounded-pill"
                                         placeholder="tanggal pengambilan" name="trsv_tgl_pengambilan"
                                         id="trsv_tgl_pengambilan">
                                     <span id="tgl-pengambilan-error" class="text-danger small"></span>
                                 </div>
                             </div>
                             <div class="col-md-4 col-12">
                                 <div class="form-group">
                                     <label for="country-floating" class="fw-semibold">Tanggal Jatuh Tempo</label>
                                     <input type="datetime-local" class="form-control shadow-sm rounded-pill"
                                         placeholder="tanggal jatuh tempo" name="trsv_jatuh_tempo"
                                         id="trsv_jatuh_tempo">
                                     <span id="trsv-jatuh-tempo-error" class="text-danger small"></span>
                                 </div>
                             </div>
                         </div>
                     </form>
                 </div>
                 <div class="modal-footer border-top-0">
                     <button type="button" class="btn btn-danger rounded-pill"
                         data-bs-dismiss="modal">Tutup</button>
                     <button type="submit" class="btn btn-primary rounded-pill"
                         id="storePengambilan">Simpan</button>
                 </div>
             </div>
         </div>
     </div>
     {{-- end modal pengambilan Buku Reservasi --}}

     {{-- show reservasi --}}
     <div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg"
             role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalCenterTitle">Lihat Detail Reservasi
                     </h5>
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
                         Tutup
                 </div>
             </div>
         </div>
     </div>
     {{-- end modal show reservasi --}}
