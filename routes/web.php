<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\InventarisAdminController;
use App\Http\Controllers\RegisterKaryawanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\buttonController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\DetailKaryawanController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\KategoriController;

Route::get('/laporan-keuangan-harian', [LaporanController::class, 'index'])->name('laporan-harian');
Route::get('/keuangan-admin', [KeuanganController::class, 'index'])->name('keuangan-admin');
Route::get('/dataCatatanKaryawan/{username}', [KeuanganController::class, 'getdata'])->name('keuangan-data');
Route::post('/laporan-keuangan/tambah', [LaporanController::class, 'tambah'])->name('laporan-keuangan.tambah');

Route::post('/catatan/update-keterangan', [CatatanController::class, 'updateKeterangan'])->name('catatan.updateKeterangan');
Route::post('/catatan/update-permainan', [CatatanController::class, 'updatePermainan'])->name('catatan.updatePermainan');

Route::post('/kategori/tambah', [KategoriController::class, 'tambah'])->name('kategori.tambah');
Route::get('/kategori/list', [KategoriController::class, 'list'])->name('kategori.list');


Route::post('/inventaris/tambah', [InventarisAdminController::class, 'tambah'])->name('inventaris.tambah');

Route::get('/karyawan', [DetailKaryawanController::class, 'show']);
Route::post('/karyawan/update', [KaryawanController::class, 'update'])->name('karyawan.update');
Route::delete('/karyawan/hapus', [DetailKaryawanController::class, 'destroy']);
// Route::delete('/karyawan/tambah', [DetailKaryawanController::class, 'store']);
Route::get('/detail-karyawan/{id}', [DetailKaryawanController::class, 'detail'])->name('detail-karyawan');

Route::get('/laporan-keuangan-harian', [LaporanController::class, 'index']);

Route::post('/karyawan/pengeluaran', [PengeluaranController::class, 'store'])->name('karyawan.addPengeluaran');

Route::get('/register-karyawan', [RegisterKaryawanController::class, 'showForm'])->name('register.karyawan');
Route::post('/register-karyawan', [RegisterKaryawanController::class, 'store'])->name('register-karyawan.store');

Route::get('auth/admin-login', [AdminLoginController::class, 'showLoginForm'])->name('auth.admin-login');
Route::post('auth/admin-login', [AdminLoginController::class, 'login']);


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/landing');
})->name('logout');


Route::get('/catatan', [CatatanController::class, 'index'])->name('catatan');

Route::get('/catatan', [CatatanController::class, 'index'])->name('catatan.index');
Route::post('/catatan/tambah', [CatatanController::class, 'tambah'])->name('catatan.tambah');
Route::post('/catatan/update', [CatatanController::class, 'update'])->name('catatan.update');
Route::post('/catatan/update-status', [CatatanController::class, 'updateStatus'])->name('catatan.updateStatus');
Route::post('/catatan/update-checkbox', [CatatanController::class, 'updateCheckbox'])->name('catatan.updateCheckbox');



Route::get('/karyawan-home', [KaryawanController::class, 'index'])->name('karyawan.home');
Route::match(['get', 'post'], '/karyawan-home', [KaryawanController::class, 'index']);

Route::get('auth/karyawan-login', [KaryawanController::class, 'showLoginForm'])->name('karyawan.login');

Route::post('auth/karyawan-login', [KaryawanController::class, 'login'])->name('karyawan.login.post');


Route::get('/admin-home', [AdminController::class, 'index'])->name('admin.home');
Route::match(['get', 'post'], '/admin-home', [AdminController::class, 'index']);

Route::get('auth/admin-login', function () {
    return view('auth.admin-login');
});

Route::post('auth/admin-login', [AdminLoginController::class, 'login'])->name('admin.login');

Route::get('inventaris-admin', [InventarisAdminController::class, 'index'])->name('inventaris-admin');
Route::post('/inventaris-admin/tambah', [InventarisAdminController::class, 'tambah'])->name('inventaris.tambah');
Route::post('/inventaris-admin/update', [InventarisController::class, 'update'])->name('inventaris.update');
Route::post('/inventaris/update', [InventarisController::class, 'update']);

Route::post('/tambah',[buttonController::class, 'tambah'])->name('tambah');
Route::post('/kurang',[buttonController::class, 'kurang'])->name('kurang');
Route::post('/kurangiRusak',[buttonController::class, 'kurangiRusak'])->name('kurangiRusak');
Route::post('/tambahiRusak',[buttonController::class, 'tambahiRusak'])->name('tambahiRusak');


// Route::get('/keuangan-admin', [KeuanganController::class, 'index']);

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
