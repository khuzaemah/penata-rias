<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PengunjungController;


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
Route::get('/', [ProfileController::class, 'home']);
Route::get('/artist', [ProfileController::class, 'artist']);
Route::get('/p-portofolio', [PortofolioController::class, 'portofolio']);
Route::get('/p-profil', [PortofolioController::class, 'profil']);
Route::get('/p-lokasi', [LokasiController::class, 'lokasi']);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('/profile', ProfileController::class);
    Route::resource('/portofolio', PortofolioController::class);
    Route::resource('/portofolio', PortofolioController::class)->except('show');
    Route::resource('/lokasi', LokasiController::class);
    // Route::resource('/range-harga', PortofolioController::class);
});

