<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Pengawas\PengawasController;
use App\Http\Controllers\Paslon\PaslonController;
use App\Http\Controllers\Pemilih\PemilihController;

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
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
Route::get('/', function () {
    return redirect( route('login')) ;
});
Route::get('/home', function () {
    return redirect( route('dashboard')) ;
});
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:ADMIN'])->group(function() {
    Route::prefix('/admin')->group(function(){
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::get('/{user}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/approve/{user}', [AdminController::class, 'approve'])->name('admin.approve');
        Route::post('/', [AdminController::class, 'store'])->name('admin.store');
        Route::put('/{user}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });

    Route::prefix('/pengawas')->group(function(){
        Route::get('/', [PengawasController::class, 'index'])->name('pengawas.index');
        Route::get('/create', [PengawasController::class, 'create'])->name('pengawas.create');
        Route::get('/{user}', [PengawasController::class, 'edit'])->name('pengawas.edit');
        Route::post('/', [PengawasController::class, 'store'])->name('pengawas.store');
        Route::put('/{user}', [PengawasController::class, 'update'])->name('pengawas.update');
        Route::delete('/{user}', [PengawasController::class, 'destroy'])->name('pengawas.destroy');
    });

    Route::prefix('/calon')->group(function(){
        Route::get('/', [PaslonController::class, 'index'])->name('calon.index');
        Route::get('/create', [PaslonController::class, 'create'])->name('calon.create');
        Route::get('/{user}', [PaslonController::class, 'edit'])->name('calon.edit');
        Route::post('/', [PaslonController::class, 'store'])->name('calon.store');
        Route::put('/{user}', [PaslonController::class, 'update'])->name('calon.update');
        Route::delete('/{user}', [PaslonController::class, 'destroy'])->name('calon.destroy');
    });

    Route::prefix('/pemilih')->group(function(){
        Route::get('/', [PemilihController::class, 'index'])->name('pemilih.index');
        Route::get('/create', [PemilihController::class, 'create'])->name('pemilih.create');
        Route::get('/{user}', [PemilihController::class, 'edit'])->name('pemilih.edit');
        Route::get('/user/voted', [PemilihController::class, 'getUserVote'])->name('pemilih.voted');
        Route::get('/user/not-voted', [PemilihController::class, 'getUserNotVote'])->name('pemilih.not_voted');
        Route::post('/', [PemilihController::class, 'store'])->name('pemilih.store');
        Route::put('/{user}', [PemilihController::class, 'update'])->name('pemilih.update');
        Route::delete('/{user}', [PemilihController::class, 'destroy'])->name('pemilih.destroy');
    });
});


