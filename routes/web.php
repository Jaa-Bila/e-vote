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

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::prefix('/admin')->middleware(['auth', 'role:ADMIN'])->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::get('/{user}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/approve/{user}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/', [AdminController::class, 'store'])->name('admin.store');
    Route::put('/{user}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
});
