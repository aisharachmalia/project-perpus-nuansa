<?php
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AksesUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PustakawanController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiswaController;


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
Route::get('/', [App\Http\Controllers\WebController::class, 'pageWeb'])->name('page_web');

//Login
Route::get('/login-usr', [App\Http\Controllers\WebController::class, 'pageLogin'])->name('login-usr');
Route::get('/home', [App\Http\Controllers\WebController::class, 'pageHome'])->name('home');

//Register
Route::get('/register', [App\Http\Controllers\WebController::class, 'pageRegister'])->name('register');

//Forgot Password
Route::get('/forgot-password', [App\Http\Controllers\WebController::class, 'pageForgotPassword'])->name('forgot_password');
Route::get('/reset-password', [App\Http\Controllers\WebController::class, 'pageForgotPassword'])->name('forgot_password');

//Register User
Route::post('/register-user', [App\Http\Controllers\Auth\RegisterController::class, 'registerUser'])->name('post_register_user');

//Verifikasi User
Route::get('/verifikasi-user/{id?}', [App\Http\Controllers\Auth\VerificationController::class, 'verificationUser'])->name('verifikasi_user');

//Login User
Route::post('/login-user', [App\Http\Controllers\Auth\LoginController::class, 'loginUser'])->name('login_user');

Route::post('/lupa-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'lupaPassword'])->name('lupa_pass');

//
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('data-master')->group(function () {
    // guru route
    Route::get('/guru', [App\Http\Controllers\GuruController::class, 'pageGuru'])->name('data_master.guru');
    Route::post('/guru/add', [App\Http\Controllers\GuruController::class, 'addGuru'])->name('data_master.guru.add');
    Route::get('/guru/show/{id}', [App\Http\Controllers\GuruController::class, 'showGuru'])->name('data_master.guru.show');
    Route::put('/guru/edit/{id}', [App\Http\Controllers\GuruController::class, 'editGuru'])->name('data_master.guru.edit');
    Route::delete('/guru/delete/{id}', [App\Http\Controllers\GuruController::class, 'deleteGuru'])->name('data_master.guru.delete');

    //Buku
    Route::get('/buku',[App\Http\Controllers\BukuController::class, 'pageBuku'])->name('data_master.buku');
    Route::get('/table-buku',[App\Http\Controllers\BukuController::class, 'tableBuku'])->name('table_dm_buku');
    Route::match(['post','put','delete'],'/crud-buku/{id?}',[App\Http\Controllers\BukuController::class, 'crudBuku'])->name('crud_dm_buku');

    // PUSTAKAWAN
    Route::get('/pustakawan', [App\Http\Controllers\PustakawanController::class, 'pagePustakawan'])->name('data_master.pustakawan');
    Route::get('/pustakawan/show/{id}', [App\Http\Controllers\PustakawanController::class, 'showPustakawan'])->name('data_master.pustakawan.show');
    Route::post('/pustakawan/add', [App\Http\Controllers\PustakawanController::class, 'addPustakawan'])->name('data_master.pustakawan.add');
    Route::put('/pustakawan/edit/{id}', [App\Http\Controllers\PustakawanController::class, 'editPustakawan'])->name('data_master.pustakawan.edit');
    Route::delete('/pustakawan/delete/{id}', [App\Http\Controllers\PustakawanController::class, 'deletePustakawan'])->name('data_master.pustakawan.delete');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('data_master.siswa');
    Route::post('/siswa/add', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/show/{id}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::put('/siswa/update/{id?}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/export-siswa',[App\Http\Controllers\SiswaController::class, 'exportSiswa'])->name('export_siswa');

    // Kelas
    Route::get('/kelas', [App\Http\Controllers\KelasController::class, 'index'])->name('data_master.kelas');
    Route::get('/kelas-detail/{id?}', [App\Http\Controllers\KelasController::class, 'detail'])->name('kelas.detail');
    Route::delete('/kelas/delete/{id?}', [App\Http\Controllers\KelasController::class, 'destroy'])->name('kelas.delete');
    Route::put('/kelas-update/{id?}', [App\Http\Controllers\KelasController::class, 'update'])->name('kelas.update');

    // refernsi route
    Route::get('/referensi', [App\Http\Controllers\ReferensiController::class, 'pageReferensi'])->name('data_master.referensi');

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


    // kategori route
    Route::get('/dkategori', [App\Http\Controllers\ReferensiController::class, 'dkategori']);
    Route::post('/kategori/add', [App\Http\Controllers\ReferensiController::class, 'addKategori'])->name('data_master.referensi.kategori.add');
    Route::put('/kategori/edit/{id?}', [App\Http\Controllers\ReferensiController::class, 'editKategori'])->name('data_master.referensi.kategori.edit');
    Route::get('/kategori/show/{id?}', [App\Http\Controllers\ReferensiController::class, 'showKategori'])->name('data_master.referensi.kategori.show');
    Route::delete('/kategori/delete/{id?}', [App\Http\Controllers\ReferensiController::class, 'deleteKategori'])->name('data_master.referensi.kategori.delete');
});
Route::get('/forgot-password', [App\Http\Controllers\WebController::class, 'pageForgotPassword'])->name('forgot_password');
Route::post('/lupa-password', [ForgotPasswordController::class, 'lupaPassword'])->name('lupa_pass');
Route::get('/reset-password/{id?}', [App\Http\Controllers\WebController::class, 'pageResetPassword'])->name('form_reset_password');
Route::post('/reset-Password', [ForgotPasswordController::class, 'storePassword'])->name('reset_pass');
