<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PengaturanWeb;
use App\Http\Controllers\Analytic\LaporanHasilPerolehan;
use App\Http\Controllers\Analytic\RekapPerolehanSuara;
use App\Http\Controllers\Menu\MenuController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::get('/visi-misi', [HomeController::class, 'visiMisi'])->name('visi_misi');
Route::get('/informasi-pemilihan', [HomeController::class, 'informasiPemilihan'])->name('informasi_pemilihan');
Route::get('/panduan-memilih', [HomeController::class, 'panduanMemilih'])->name('panduan_memilih');
Route::get('/jumlah-pemilih', [HomeController::class, 'jumlahPemilih'])->name('jumlah_pemilih');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::get('/home', function () {
    return redirect('dashboard') ;
});

Route::middleware(['auth', 'role:ADMIN'])->group(function() {
    Route::prefix('/admin')->group(function(){
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('{user}/show', [AdminController::class, 'show'])->name('admin.show');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::get('/{user}', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/activate/{user}', [AdminController::class, 'activate'])->name('admin.activate');
        Route::post('/', [AdminController::class, 'store'])->name('admin.store');
        Route::put('/{user}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });

    Route::prefix('/pengawas')->group(function(){
        Route::get('/', [PengawasController::class, 'index'])->name('pengawas.index');
        Route::get('{user}/show', [PengawasController::class, 'show'])->name('pengawas.show');
        Route::get('/create', [PengawasController::class, 'create'])->name('pengawas.create');
        Route::get('/{user}', [PengawasController::class, 'edit'])->name('pengawas.edit');
        Route::post('/activate/{user}', [PengawasController::class, 'activate'])->name('pengawas.activate');
        Route::post('/', [PengawasController::class, 'store'])->name('pengawas.store');
        Route::put('/{user}', [PengawasController::class, 'update'])->name('pengawas.update');
        Route::delete('/{user}', [PengawasController::class, 'destroy'])->name('pengawas.destroy');
    });

    Route::prefix('/calon')->group(function(){
        Route::get('/', [PaslonController::class, 'index'])->name('calon.index');
        Route::get('/create', [PaslonController::class, 'create'])->name('calon.create');
        Route::get('/{user}', [PaslonController::class, 'edit'])->name('calon.edit');
        Route::post('/activate/{user}', [PaslonController::class, 'activate'])->name('calon.activate');
        Route::post('/', [PaslonController::class, 'store'])->name('calon.store');
        Route::put('/{user}', [PaslonController::class, 'update'])->name('calon.update');
        Route::delete('/{user}', [PaslonController::class, 'destroy'])->name('calon.destroy');
    });

    Route::prefix('/pemilih')->group(function(){
        Route::get('/create', [PemilihController::class, 'create'])->name('pemilih.create');
        Route::post('/', [PemilihController::class, 'store'])->name('pemilih.store');
        Route::delete('/{user}', [PemilihController::class, 'destroy'])->name('pemilih.destroy');
    });

    Route::prefix('/pengguna')->group(function() {
        Route::get('/', [MenuController::class, 'index'])->name('menu.index');
        Route::get('/{menu}', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('menu.update');
    });

    Route::prefix('/rekap-perolehan')->group(function() {
        Route::get('/', [RekapPerolehanSuara::class, 'index'])->name('rekap_perolehan.index');
    });

    Route::prefix('laporan-hasil-perolehan')->group(function(){
        Route::get('/', [LaporanHasilPerolehan::class, 'index'])->name('laporan_hasil_perolehan.index');
        Route::get('/download', [LaporanHasilPerolehan::class, 'exportPDF'])->name('laporan_hasil_perolehan.download');
    });

    Route::prefix('pengaturan-web')->group(function(){
        Route::get('/', [PengaturanWeb::class, 'index'])->name('pengaturan_web.index');
        Route::get('/gallery', [PengaturanWeb::class, 'indexGalleries'])->name('pengaturan_web.indexGalleries');
        Route::get('/gallery/create', [PengaturanWeb::class, 'createGalleries'])->name('pengaturan_web.createGalleries');
        Route::get('/carousel', [PengaturanWeb::class, 'indexLandingCarousel'])->name('pengaturan_web.indexLandingCarousel');
        Route::get('/carousel/create', [PengaturanWeb::class, 'createCarousel'])->name('pengaturan_web.createCarousel');
        Route::get('/election-information', [PengaturanWeb::class, 'indexElectionInformation'])->name('pengaturan_web.indexElectionInformation');
        Route::get('/election-information/{electionInformation}', [PengaturanWeb::class, 'editElectionInformation'])->name('pengaturan_web.editElectionInformation');
        Route::get('/marquee', [PengaturanWeb::class, 'indexMarquee'])->name('pengaturan_web.indexMarquee');
        Route::get('/marquee/create', [PengaturanWeb::class, 'createMarquee'])->name('pengaturan_web.createMarquee');
        Route::get('/marquee/{marqueeText}', [PengaturanWeb::class, 'editMarquee'])->name('pengaturan_web.editMarquee');

        Route::post('/marquee', [PengaturanWeb::class, 'storeMarquee'])->name('pengaturan_web.storeMarquee');
        Route::post('/carousel', [PengaturanWeb::class, 'storeCarousel'])->name('pengaturan_web.storeCarousel');
        Route::post('/gallery', [PengaturanWeb::class, 'storeGallery'])->name('pengaturan_web.storeGallery');

        Route::put('/election-information/{electionInformation}', [PengaturanWeb::class, 'updateElectionInformation'])->name('pengaturan_web.updateElectionInformation');
        Route::put('/marquee/{marqueeText}', [PengaturanWeb::class, 'updateMarquee'])->name('pengaturan_web.updateMarquee');

        Route::delete('/marquee/{marqueeText}', [PengaturanWeb::class, 'deleteMarquee'])->name('pengaturan_web.deleteMarquee');
        Route::delete('/carousel/{landingCarouselPhoto}', [PengaturanWeb::class, 'deleteCarousel'])->name('pengaturan_web.deleteCarousel');
        Route::delete('/gallery/{gallery}', [PengaturanWeb::class, 'deleteGallery'])->name('pengaturan_web.deleteGallery');
    });
});

Route::middleware(['auth', 'role:PENGAWAS'])->group(function(){

    Route::prefix('/pemilih')->group(function(){
        Route::get('/', [PemilihController::class, 'index'])->name('pemilih.index');
        Route::post('/activate/{user}', [PemilihController::class, 'activate'])->name('pemilih.activate');
        Route::get('/{user}', [PemilihController::class, 'edit'])->name('pemilih.edit');
        Route::get('{user}/show', [PemilihController::class, 'show'])->name('pemilih.show');
        Route::post('/foto', [PemilihController::class, 'fotoPengawas'])->name('pemilih.foto_pengawas');
        Route::put('/{user}', [PemilihController::class, 'update'])->name('pemilih.update');
        Route::get('/user/voted', [PemilihController::class, 'getUserVote'])->name('pemilih.voted');
        Route::get('/user/not-voted', [PemilihController::class, 'getUserNotVote'])->name('pemilih.not_voted');
    });
});

Route::middleware(['auth', 'role:PASLON'])->group(function(){
    Route::prefix('/calon')->group(function(){
        Route::get('/', [PaslonController::class, 'index'])->name('calon.index');
        Route::get('{user}/show', [PaslonController::class, 'show'])->name('calon.show');
        Route::get('/{user}', [PaslonController::class, 'edit'])->name('calon.edit');
        Route::put('/{user}', [PaslonController::class, 'update'])->name('calon.update');
    });
});

Route::middleware(['check_vote', 'auth'])->group(function(){
    Route::get('/pilkades', [PemilihController::class, 'votePage'])->name('pemilih.vote_page');
    Route::post('/pilkades', [PemilihController::class, 'vote'])->name('pemilih.vote');
});

