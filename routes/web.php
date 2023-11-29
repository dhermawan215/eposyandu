<?php


use App\Http\Controllers\AdminKategoriPeserta;
use App\Http\Controllers\AdminPeserta;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\PesertaController;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\Route;

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

// route umum
Route::name('app.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// route peserta(non admin)
Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta');
Route::post('/peserta/detail/{id}', [PesertaController::class, 'detail'])->name('peserta_detail');
Route::post('/peserta', [PesertaController::class, 'store']);
Route::post('/pesertas', [PesertaController::class, 'dataPeserta']);

// Route pemerikasaan peserta
Route::get('/pemeriksaan/{id}', [PemeriksaanController::class, 'pemeriksaan'])->name('pemeriksaan');
Route::post('/pemeriksaan', [PemeriksaanController::class, 'simpanPemeriksaan']);
Route::post('/pemeriksaan/riwayat', [PemeriksaanController::class, 'riwayatPemeriksaan']);

// route admin
Route::prefix('admin')->name('admin.')->group(function () {
    // admin kategori peserta routes
    Route::get('/kategori-peserta', [AdminKategoriPeserta::class, 'index'])->name('kategori_peserta');
    Route::post('/kategori-peserta', [AdminKategoriPeserta::class, 'store']);
    Route::patch('/kategori-peserta/{id}', [AdminKategoriPeserta::class, 'update']);
    Route::delete('/kategori-peserta/{id}', [AdminKategoriPeserta::class, 'destroy']);
    Route::post('/kategori-pesertas', [AdminKategoriPeserta::class, 'tableData']);
    // admin peserta routes
    Route::get('/peserta', [AdminPeserta::class, 'index'])->name('peserta');
    Route::post('/peserta', [AdminPeserta::class, 'tabelDataAdmin']);
});
