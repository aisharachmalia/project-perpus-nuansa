<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index', function () {
    return view('admin.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//user;
Route::get('/kelas', [App\Http\Controllers\KelasController::class, 'index'])->name('dmkelas.index');
Route::get('/kelas-detail/{id?}', [App\Http\Controllers\KelasController::class, 'detail'])->name('kelas.detail');
Route::delete('/kelas/delete/{id?}', [App\Http\Controllers\KelasController::class, 'destroy'])->name('kelas.delete');
Route::put('/kelas-update/{id?}', [App\Http\Controllers\KelasController::class, 'update'])->name('kelas.update');



// Rute untuk halaman daftar siswa
Route::get('/siswa', [SiswaController::class, 'index'])->name('dmsiswa.index');
Route::post('/siswa/add', [SiswaController::class, 'store'])->name('siswa.store');
Route::get('/siswa/show/{id}', [SiswaController::class, 'show'])->name('siswa.show');
Route::put('/siswa/update/{id?}', [SiswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
