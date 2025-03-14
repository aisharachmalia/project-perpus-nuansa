<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
Route::get('/', [App\Http\Controllers\UsePageController::class, 'berandaPage'])->name('beranda.page');
Route::get('/rekomendasi-buku', [App\Http\Controllers\HomeController::class, 'rekomendasiBuku'])->name('rekomendasi.buku');
Route::get('/tentang', [App\Http\Controllers\WebController::class, 'pageTentang'])->name('tentang');
Route::get('/halaman-buku', [App\Http\Controllers\UsePageController::class, 'pageBuku'])->name('buku');
Route::get('/search', [App\Http\Controllers\UsePageController::class, 'pageBuku'])->name('buku.search');
Route::get('/halaman-buku/{penerbit?}', [App\Http\Controllers\UsePageController::class, 'pageBukuByPenerbit'])->name('BukuByPenerbit');
Route::get('/halaman-penulis/favorit', [App\Http\Controllers\UsePageController::class, 'PagePenulsFav'])->name('Page-Penulis-Fav');
Route::get('/penulis-favorit', [App\Http\Controllers\UsePageController::class, 'penulisFavorit'])->name('penulis.favorit');

// Route untuk memuat lebih banyak buku favorit
Route::post('/penulis/load-more-books-fav', [App\Http\Controllers\UsePageController::class, 'loadMoreBooksFav'])->name('penulis.loadMoreBooksFav');

// Route untuk penulis lokal dan asing
Route::get('/penulis-lokal', [App\Http\Controllers\UsePageController::class, 'penulisLokal'])->name('penulis.lokal');
Route::post('/penulis/load-more-books-lokal', [App\Http\Controllers\UsePageController::class, 'loadMoreBooks'])->name('penulis.loadMoreBooksLokal');

Route::get('/penulis-asing', [App\Http\Controllers\UsePageController::class, 'penulisAsing'])->name('penulis.asing');
Route::post('/penulis/load-more-books-asing', [App\Http\Controllers\UsePageController::class, 'loadMoreBooksAsing'])->name('penulis.loadMoreBooksAsing');

// Route::get('/load-more-authors', [App\Http\Controllers\UsePageController::class, 'loadMoreAuthors']);
// Route::get('/load-more-books', [UsePageController::class, 'loadMoreBooks'])->name('loadMoreBooks');

Route::get('/panduan', [App\Http\Controllers\WebController::class, 'pagePanduan'])->name('panduan');

//Login
Route::get('/login-usr', [App\Http\Controllers\WebController::class, 'pageLogin'])->name('login-usr');
Route::post('/login-user', [App\Http\Controllers\Auth\LoginController::class, 'loginUser'])->name('login_user');

//Register
Route::get('/register', [App\Http\Controllers\WebController::class, 'pageRegister'])->name('register');
Route::post('/register-user', [App\Http\Controllers\Auth\RegisterController::class, 'registerUser'])->name('post_register_user');

//Forgot Password
Route::get('/reset-password', [App\Http\Controllers\WebController::class, 'pageForgotPassword'])->name('forgot_password');
Route::get('/forgot-password', [App\Http\Controllers\WebController::class, 'pageForgotPassword'])->name('forgot_password');
Route::post('/lupa-password', [ForgotPasswordController::class, 'lupaPassword'])->name('lupa_pass');
Route::get('/reset-password/{id?}', [App\Http\Controllers\WebController::class, 'pageResetPassword'])->name('form_reset_password');
Route::post('/reset-Password', [ForgotPasswordController::class, 'storePassword'])->name('reset_pass');

//Verifikasi User
Route::get('/verifikasi-user/{id?}', [App\Http\Controllers\Auth\VerificationController::class, 'verificationUser'])->name('verifikasi_user');

//
Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/total-data-dashboard', [App\Http\Controllers\HomeController::class, 'totalDataDashboard'])->name('total_data_dashboard');
Route::get('/data-leaderboard', [App\Http\Controllers\HomeController::class, 'totalDataDashboard'])->name('data-leaderboard');
Route::post('/update-chart', [App\Http\Controllers\HomeController::class, 'updateChart'])->name('update.chart');

Route::prefix('data-master')->middleware('auth')->group(function () {
    // guru route
    Route::get('/guru', [App\Http\Controllers\GuruController::class, 'pageGuru'])->name('data_master.guru');
    Route::post('/guru/add', [App\Http\Controllers\GuruController::class, 'addGuru'])->name('data_master.guru.add');
    Route::get('/guru/show/{id}', [App\Http\Controllers\GuruController::class, 'showGuru'])->name('data_master.guru.show');
    Route::put('/guru/edit/{id}', [App\Http\Controllers\GuruController::class, 'editGuru'])->name('data_master.guru.edit');
    Route::delete('/guru/delete/{id}', [App\Http\Controllers\GuruController::class, 'deleteGuru'])->name('data_master.guru.delete');
    //export
    Route::get('/export-guru', [App\Http\Controllers\GuruController::class, 'exportGuru'])->name('export_dm_guru');
    Route::post('/link-export-guru', [App\Http\Controllers\GuruController::class, 'linkExportGuru'])->name('link_export_dm_guru');
    //pdf
    Route::get('/printout-guru', [App\Http\Controllers\GuruController::class, 'printoutGuru'])->name('printout_guru');
    Route::get('/printout-pustakawan', [App\Http\Controllers\PustakawanController::class, 'printoutPustakawan'])->name('printout_pustakawan');
    Route::post('/link-printout-guru', [App\Http\Controllers\GuruController::class, 'linkPrintoutGuru'])->name('link_printout_guru');
    Route::post('/link-printout-buku', [App\Http\Controllers\BukuController::class, 'linkPrintoutBuku'])->name('link_printout_buku');
    Route::post('/link-printout-pustakawan', [App\Http\Controllers\PustakawanController::class, 'linkPrintoutPustakawan'])->name('link_printout_pustakawan');

    //Buku
    Route::get('/buku', [App\Http\Controllers\BukuController::class, 'pageBuku'])->name('data_master.buku');
    Route::get('/table-buku', [App\Http\Controllers\BukuController::class, 'tableBuku'])->name('table_dm_buku');
    Route::match(['post', 'put', 'delete'], '/crud-buku/{id?}', [App\Http\Controllers\BukuController::class, 'crudBuku'])->name('crud_dm_buku');
    Route::get('/buku/show/{id}', [App\Http\Controllers\BukuController::class, 'showBuku'])->name('data_master.buku.show');

    Route::get('/salinan-buku/{id}', [App\Http\Controllers\DmSalinanBukuController::class, 'pageDmSalinanBuku'])->name('pageDmSalinanBuku');
    Route::get('/table-salinan-buku/{id}', [App\Http\Controllers\DmSalinanBukuController::class, 'tableDmSalinanBuku'])->name('table_dm_salinan_buku');
    Route::get('/buku-salinan/{id}', [App\Http\Controllers\DmSalinanBukuController::class, 'salinanDetail'])->name('buku-salinan');
    Route::match(['post', 'put', 'delete'], '/crud-salinan-buku/{id?}', [App\Http\Controllers\DmSalinanBukuController::class, 'crudSalinanBuku'])->name('crud_dm_salinan_buku');

    Route::post('/link-export-buku', [App\Http\Controllers\BukuController::class, 'linkExportBuku'])->name('link_export_buku');
    Route::get('/export-buku', [App\Http\Controllers\BukuController::class, 'exportBuku'])->name('export_buku');

    Route::post('/link-printout-buku', [App\Http\Controllers\BukuController::class, 'linkPrintoutBuku'])->name('link_printout_buku');
    Route::get('/printout-buku', [App\Http\Controllers\BukuController::class, 'printoutBuku'])->name('printout_buku');

    Route::post('/link-export-salinan-buku', [App\Http\Controllers\DmSalinanBukuController::class, 'linkExportBuku'])->name('link_export_salinan_buku');
    Route::get('/export-salinan-buku', [App\Http\Controllers\DmSalinanBukuController::class, 'exportBuku'])->name('export_salinan_buku');


    Route::post('/link-printout-salinan-buku', [App\Http\Controllers\DmSalinanBukuController::class, 'linkPrintoutBuku'])->name('link_printout_salinan_buku');
    Route::get('/printout-salinan-buku', [App\Http\Controllers\DmSalinanBukuController::class, 'printoutBuku'])->name('printout_salinan_buku');

    // PUSTAKAWAN
    Route::get('/pustakawan', [App\Http\Controllers\PustakawanController::class, 'pagePustakawan'])->name('data_master.pustakawan');
    Route::get('/pustakawan/show/{id}', [App\Http\Controllers\PustakawanController::class, 'showPustakawan'])->name('data_master.pustakawan.show');
    Route::post('/pustakawan/add', [App\Http\Controllers\PustakawanController::class, 'addPustakawan'])->name('data_master.pustakawan.add');
    Route::put('/pustakawan/edit/{id}', [App\Http\Controllers\PustakawanController::class, 'editPustakawan'])->name('data_master.pustakawan.edit');
    Route::delete('/pustakawan/delete/{id}', [App\Http\Controllers\PustakawanController::class, 'deletePustakawan'])->name('data_master.pustakawan.delete');
    Route::post('/link-export-pustakawan', [App\Http\Controllers\PustakawanController::class, 'linkExportPustakawan'])->name('link_export_pustakawan');
    Route::get('/export-pustakawan', [App\Http\Controllers\PustakawanController::class, 'exportPustakawan'])->name('export_pustakawan');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('data_master.siswa');
    Route::post('/siswa/add', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/show/{id}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::put('/siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

    Route::post('/link-export-siswa', [App\Http\Controllers\SiswaController::class, 'linkExportSiswa'])->name('link_export_siswa');
    Route::get('/export-siswa', [App\Http\Controllers\SiswaController::class, 'exportSiswa'])->name('export_siswa');

    Route::post('/link-printout-siswa', [App\Http\Controllers\SiswaController::class, 'linkPrintoutSiswa'])->name('link_printout_siswa');
    Route::get('/printout-siswa', [App\Http\Controllers\SiswaController::class, 'printoutSiswa'])->name('printout_siswa');



    // refernsi route
    Route::get('/referensi', [App\Http\Controllers\ReferensiController::class, 'pageReferensi'])->name('data_master.referensi');
    // excel
    Route::get('/referensi/export', [App\Http\Controllers\ReferensiController::class, 'exportReferensi'])->name('referensi.export');
    Route::post('/link/export', [App\Http\Controllers\ReferensiController::class, 'linkExport'])->name('referensi.linkExport');
    // pdf
    Route::get('/referensi/printout', [App\Http\Controllers\ReferensiController::class, 'printoutReferensi'])->name('referensi.printout');
    Route::post('/link/printout', [App\Http\Controllers\ReferensiController::class, 'linkPrintout'])->name('referensi.linkPrintout');


    // penulis route
    Route::get('/dpenulis', [App\Http\Controllers\ReferensiController::class, 'dpenulis']);
    Route::post('/penulis/add', [App\Http\Controllers\ReferensiController::class, 'addPenulis'])->name('data_master.referensi.penulis.add');
    Route::put('/penulis/edit/{id?}', [App\Http\Controllers\ReferensiController::class, 'editPenulis'])->name('data_master.referensi.penulis.edit');
    Route::get('/penulis/show/{id?}', [App\Http\Controllers\ReferensiController::class, 'showPenulis'])->name('data_master.referensi.penulis.show');
    Route::delete('/penulis/delete/{id?}', [App\Http\Controllers\ReferensiController::class, 'deletePenulis'])->name('data_master.referensi.penulis.delete');

    // penerbit route
    Route::get('/dpenerbit', [App\Http\Controllers\ReferensiController::class, 'dpenerbit']);
    Route::post('/penerbit/add', [App\Http\Controllers\ReferensiController::class, 'addPenerbit'])->name('data_master.referensi.penerbit.add');
    Route::put('/penerbit/edit/{id?}', [App\Http\Controllers\ReferensiController::class, 'editPenerbit'])->name('data_master.referensi.penerbit.edit');
    Route::get('/penerbit/show/{id?}', [App\Http\Controllers\ReferensiController::class, 'showPenerbit'])->name('data_master.referensi.penerbit.show');
    Route::delete('/penerbit/delete/{id?}', [App\Http\Controllers\ReferensiController::class, 'deletePenerbit'])->name('data_master.referensi.penerbit.delete');


    Route::prefix('kategori')->group(function () {
        Route::get('/', [ReferensiController::class, 'dkategori'])->name('kategori.index');
        Route::post('/store', [ReferensiController::class, 'addKategori'])->name('kategori.store');
        Route::get('/edit/{id}', [ReferensiController::class, 'editKategori'])->name('kategori.edit');
        Route::post('/update/{id}', [ReferensiController::class, 'editKategori'])->name('kategori.update');
        Route::get('/show/{id}', [ReferensiController::class, 'showKategori'])->name('kategori.show');
        Route::delete('/delete/{id}', [ReferensiController::class, 'deleteKategori'])->name('kategori.delete');
        Route::get('/export', [ReferensiController::class, 'linkExport'])->name('kategori.export');
        Route::get('/kategori/list', [ReferensiController::class, 'dkategori'])->name('kategori.list');

    });

    // Kelas
    Route::get('/kelas', [App\Http\Controllers\KelasController::class, 'index'])->name('data_master.referensi.kelas');
    Route::get('/kelas-detail/{id?}', [App\Http\Controllers\KelasController::class, 'detail'])->name('data_master.referensi.kelas.detail');
    Route::delete('/kelas/delete/{id?}', [App\Http\Controllers\KelasController::class, 'destroy'])->name('data_master.referensi.kelas.delete');
    Route::put('/kelas-update/{id?}', [App\Http\Controllers\KelasController::class, 'update'])->name('data_master.referensi.kelas.update');
});

Route::prefix('laporan')->middleware('auth')->group(function () {
    Route::get('/laporan-transaksi', [App\Http\Controllers\LaporanController::class, 'pageLaporan'])->name('pageLaporan');
    Route::get('/table-laporan-transaksi', [App\Http\Controllers\LaporanController::class, 'tableTrks'])->name('table_lap_trks');

    Route::post('/link-export-laporan', [App\Http\Controllers\LaporanController::class, 'linkExportLaporan'])->name('link_export_laporan');
    Route::get('/export-laporan', [App\Http\Controllers\LaporanController::class, 'exportLaporan'])->name('export_laporan');

    Route::post('/link-printout-laporan', [App\Http\Controllers\LaporanController::class, 'linkPrintoutLaporan'])->name('link_printout_laporan');
    Route::get('/printout-laporan', [App\Http\Controllers\LaporanController::class, 'printoutLaporan'])->name('printout_laporan');
});

Route::prefix('setting')->middleware('auth')->group(function () {
    //crud user
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('setting.users');
    Route::get('/user-detail/{id?}', [App\Http\Controllers\UserController::class, 'detail'])->name('setting.users.detail');
    Route::delete('/user-delete/{id?}', [App\Http\Controllers\UserController::class, 'delete'])->name('setting.users.delete');
    Route::put('/user-update/{id?}', [App\Http\Controllers\UserController::class, 'update'])->name('setting.users.edit');


    //hak akses
    Route::get('/akses-user', [App\Http\Controllers\AksesUsrController::class, 'index'])->name('setting.akses-users');
    Route::get('/akses-user-show/{id?}', [App\Http\Controllers\AksesUsrController::class, 'detail'])->name('setting.user-access-show');
    Route::post('/akses-user-store', [App\Http\Controllers\AksesUsrController::class, 'store'])->name('setting.user-access-store');
    Route::put('/default-password/{id?}', [App\Http\Controllers\AksesUsrController::class, 'defaultPassword'])->name('setting.user-default-password');
});

// route denda
Route::get('/denda', [App\Http\Controllers\DendaController::class, 'index'])->name('denda');
Route::get('/denda-detail/{id?}', [App\Http\Controllers\DendaController::class, 'detail'])->name('detail_denda');
Route::get('/denda-buku-detail/{id?}', [App\Http\Controllers\DendaController::class, 'datailBuku']);
Route::post('/denda-bayar', [App\Http\Controllers\DendaController::class, 'bayar'])->name('bayar_denda');
Route::get('/table-denda', [App\Http\Controllers\DendaController::class, 'table']);


// route reservasi
route::get('/reservasi/table,', [\App\Http\Controllers\ReservasiController::class, 'index'])->name('reservasi-table');

// route transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::post('/peminjaman/add', [TransaksiController::class, 'createPeminjaman'])->name('pinjam.store');
// edit peminjaman transaksi
Route::get('/transaksi/detail/update/{id}', [TransaksiController::class, 'showEditTransaksi']);
Route::put('/transaksi/update/{id}', [TransaksiController::class, 'editTransaksi'])->name('transaksi.update');
Route::post('/pengembalian', [TransaksiController::class, 'pengembalian']);
Route::get('/transaksi/detail', [TransaksiController::class, 'detail']);
Route::get('/transaksi/detailBuku', [TransaksiController::class, 'detailBuku']);
Route::delete('/transaksi/delete/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');

Route::get('/document/{id}', [App\Http\Controllers\BacaOnlineController::class, 'documentDetail'])->name('document.detail');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::post('/update-profile', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('update_profile');
Route::post('/upload-image', [App\Http\Controllers\ProfileController::class, 'updateProfileImage'])->name('update_profile_image');


// reservasi
Route::post('/reservasi/store', [ReservasiController::class, 'createReservasi'])->name('reservasi.store');
Route::post('/pengambilan/store', [ReservasiController::class, 'createPengambilan'])->name('pengambilan.store');
Route::get('/reservasi/detail', [ReservasiController::class, 'detailReservasi'])->name('reservasi.detail');
Route::get('/reservasi/detail/{id?}', [ReservasiController::class, 'detailUpdate'])->name('reservasi.detail');
Route::put('/reservasi/update/{id}', [ReservasiController::class, 'update'])->name('reservasi.update');


Route::post('/start-reading/{id}', [App\Http\Controllers\BacaOnlineController::class, 'startReading'])->name('startReading');
// Route untuk selesai baca
Route::post('/finish-reading/{id}', [App\Http\Controllers\BacaOnlineController::class, 'finishReading'])->name('finishReading');

Route::get('/history', [App\Http\Controllers\BacaOnlineController::class, 'historyBaca'])->name('history');
Route::post('/transaksi/batal', [ReservasiController::class, 'batalTransaksi'])->name('reservasi.batal');
