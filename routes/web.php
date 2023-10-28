<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

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

// Login
Route::get('/', [SesiController::class, 'index'])->name('login');
Route::post('/', [SesiController::class, 'login']);

Route::get('/logout', [SesiController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard');

    // CRUD
    Route::get('/listbuku', [BukuController::class, 'index'])->name('buku.index');
    Route::match(['get', 'post'], '/tambahbuku', [BukuController::class, 'create'])->name('tambahbuku');
    // Route::get('/tambahbuku', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku/store', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/edit/{isbn}', [BukuController::class, 'edit'])->name('buku.edit');
    // Route::put('/buku/update/{isbn}', [BukuController::class, 'update'])->name('buku.update');
    Route::put('/buku/update/{isbn}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{isbn}', [BukuController::class, 'destroy'])->name('buku.destroy');


    // Verifikasi
    Route::get('verifikasi', [AnggotaController::class, 'showAll']);
    Route::post('verifikasi', [AnggotaController::class, 'verifikasi'])->name('verifikasi');


    //Transaksi
    Route::view('/form-peminjaman', 'transaksi/form-peminjaman')->name('form-peminjaman');
    Route::get('/transaksi', [TransaksiController::class, 'berlangsung'])->name('transaksi.index');
    Route::get('/transaksi/berlangsung', [TransaksiController::class, 'berlangsung'])->name('transaksi.berlangsung');
    Route::get('/transaksi/melebihi', [TransaksiController::class, 'melebihi'])->name('transaksi.melebihi');
    Route::get('/transaksi/selesai', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
    // Route::view('/form-peminjaman', 'transaksi/form-peminjaman')->name('form-peminjaman');
    // Route::post('/form-peminjaman', [TransaksiController::class, 'add'])->name('transaksi.form-peminjaman');
    Route::post('/form-peminjaman', [TransaksiController::class, 'add'])->name('transaksi.form-peminjaman');
    // Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    // Route::get('/transaksi/berlangsung', [TransaksiController::class, 'berlangsung'])->name('transaksi.berlangsung');
    // Route::get('/transaksi/melebihi', [TransaksiController::class, 'melebihi'])->name('transaksi.melebihi');
    // Route::get('/transaksi/selesai', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
    // Route::post('/form-peminjaman', [TransaksiController::class, 'add'])->name('transaksi.form-peminjaman');
});
