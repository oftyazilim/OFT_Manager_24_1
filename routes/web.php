<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\pages\IsEmirleri;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\satis\SatisController;
use App\Http\Controllers\stoklar\StoklarController;

Route::get('/', [Landing::class, 'index'])->name('front-pages-landing');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {


  // Main Page Route
  Route::get('/home', [HomePage::class, 'index'])->name('pages-home');
  Route::get('/kullanicilar', [UserManagement::class, 'GetUser'])->name('kullanicilar');
  Route::get('/isemirleri', [IsEmirleri::class, 'index'])->name('pages-isemirleri');
  Route::get('/table/test', [IsEmirleri::class, 'TestAl'])->name('test-al');

  // locale
  Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
  Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

  // authentication
  Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
  Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
  Route::resource('/user-list', UserManagement::class);
  Route::resource('/emir-list', IsEmirleri::class);
  Route::resource('/satis-list', SatisController::class);
  Route::resource('/stok-list', StoklarController::class);

  Route::get('/api/emirler', [IsEmirleri::class, 'getEmirler'])->name('api.emirler');

  Route::get('/stoklar/kalite2', [StoklarController::class, 'getKalite2'])->name('stoklar.kalite2');
  Route::get('/stoklar/kalite2liste', [StoklarController::class, 'getKalite2liste'])->name('stoklar.kalite2liste');

  Route::get('/stoklar/kalite2s', [StoklarController::class, 'getKalite2s'])->name('stoklar.kalite2s');
  Route::post('/stoklar/kalite2-ekle', [StoklarController::class, 'ekleKalite2']);
  Route::post('/stoklar/kalite2s-ekle', [StoklarController::class, 'ekleKalite2s']);
  Route::get('/paket-no-al/{hat}', [StoklarController::class, 'paketNoAl']);
  Route::get('/paket-no-als/{hat}', [StoklarController::class, 'paketNoAls']);
  Route::get('/stoklar/kalite2-sil/{id}', [StoklarController::class, 'silKalite2']);
  Route::get('/stoklar/kalite2s-sil/{id}', [StoklarController::class, 'silKalite2s']);
  Route::put('/stoklar/kalite2-guncelle/{id}', [StoklarController::class, 'guncelleKalite2']);
  Route::put('/stoklar/kalite2s-guncelle/{id}', [StoklarController::class, 'guncelleKalite2s']);
  Route::get('/stoklar/kalite2-listele', [StoklarController::class, 'listeleKalite2']);
  Route::get('/stoklar/kalite2s-listele', [StoklarController::class, 'listeleKalite2s']);
  Route::get('/user', [StoklarController::class, 'getUserInfo']);
  Route::get('/mamulkodu', [StoklarController::class, 'getMamulKodu']);
  Route::get('/mamulkodus', [StoklarController::class, 'getMamulKodus']);

  Route::get('/satis/musteriSiparisleri', [SatisController::class, 'getUser'])->name('satis-musteriSiparisleri');
  Route::get('/stok/verial', [StoklarController::class, 'veriAl']);

  // Route::middleware([
  //   'auth:sanctum',
  //   config('jetstream.auth_session'),
  //   'verified',
  // ])->group(function () {
  //   Route::get('/dashboard', function () {
  //     return view('content.dashboard.dashboards-analytics');
  //   })->name('dashboard');
  // });
});
