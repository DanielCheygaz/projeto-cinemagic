<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\ScreeningsController;
use App\Http\Controllers\TheatersController;

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

/* ----- PUBLIC ROUTES ----- */
Route::view('/', 'home')->name('home');

/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ----- Verified users ----- */
Route::middleware('auth', 'verified')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/auth.php';

Route::get('/', [MoviesController::class, 'index']);
<<<<<<< HEAD

Route::resource('movies', MoviesController::class);
Route::resource('screenings', ScreeningsController::class);
=======


Route::resource('movies', MoviesController::class);
Route::resource('screenings', ScreeningsController::class);
Route::resource('theaters', TheatersController::class);
>>>>>>> ramo-digas
