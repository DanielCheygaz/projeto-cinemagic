<?php

use App\Http\Controllers\ProfileController;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\ScreeningsController;
use App\Http\Controllers\TheatersController;
use App\Http\Controllers\UsersController;

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

Route::get('movies/showcase', [MoviesController::class, 'showcase'])
    ->name('movies.showcase')
    ->can('viewShowCase', Movie::class);

Route::get('screenings/showcase', [ScreeningsController::class, 'showcase'])
    ->name('screenings.showcase')
    ->can('viewShowCase', Screening::class);



/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ----- Verified users ----- */
Route::middleware('auth', 'verified')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::delete('movies/{movie}/image', [MoviesController::class, 'destroyImage'])
    ->name('movies.image.destroy')
    ->can('update', Movie::class);



    Route::resource('movies', MoviesController::class);
    Route::resource('screenings', ScreeningsController::class);
    Route::resource('theaters', TheatersController::class);

});

require __DIR__.'/auth.php';

Route::get('/', [MoviesController::class, 'index']);


Route::resource('movies', MoviesController::class)->only(['index', 'show']);
Route::resource('screenings', ScreeningsController::class)->only(['index', 'show']);    
Route::resource('users', UsersController::class);

Route::patch('/users/{user}', [UsersController::class, 'block'])->name('users.block');
