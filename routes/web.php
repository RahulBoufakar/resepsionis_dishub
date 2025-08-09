<?php

use App\Http\Controllers\ArsipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Admin Only
    Route::middleware(['admin'])->group(function () {
        Route::resource('surat-masuk', SuratMasukController::class)->except(['index', 'show']);
        Route::resource('surat-keluar', SuratKeluarController::class)->except(['index', 'show']);
        Route::resource('users', UserController::class)->except(['show', 'edit', 'update']);
    });

    // Viewer + Admin bisa lihat
    Route::get('surat-masuk', [SuratMasukController::class, 'index'])->name('surat-masuk.index');
    Route::get('surat-masuk/{suratMasuk}', [SuratMasukController::class, 'show'])->name('surat-masuk.show');

    Route::get('surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.index');
    Route::get('surat-keluar/{suratKeluar}', [SuratKeluarController::class, 'show'])->name('surat-keluar.show');

    // Arsip (1 tahun ke belakang)
    Route::get('arsip', [ArsipController::class, 'index'])->name('arsip.index');
});

require __DIR__.'/auth.php';

// Hapus/disable register publik
Route::get('/register', function () {
    abort(404);
})->name('register')->middleware('guest');
