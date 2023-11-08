<?php

use App\Http\Controllers\AdminKategoriPeserta;
use App\Http\Controllers\DashboardController;
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

// route admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/kategori-peserta', [AdminKategoriPeserta::class, 'index'])->name('kategori_peserta');
    Route::post('/kategori-peserta', [AdminKategoriPeserta::class, 'store']);
});
