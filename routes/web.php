<?php

use App\Http\Controllers\ProfileController;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\ScreeningsController;
use App\Http\Controllers\TheatersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\CartController;
use App\Models\Theater;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ValidationsController;

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

    
    Route::get('theaters/my', [TheatersController::class, 'theaters'])
        ->name('theaters.my')
        ->can('view', Theater::class);

    Route::post('cart', [CartController::class, 'confirm'])
        ->name('cart.confirm')
        ->can('confirm-cart');

    Route::resource('movies', MoviesController::class);
    Route::resource('screenings', ScreeningsController::class);
    Route::resource('theaters', TheatersController::class);
    Route::resource('users', UsersController::class);
    Route::resource('tickets', TicketsController::class);

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/data', [StatisticsController::class, 'data'])->name('statistics.data');

    Route::get('/validation', [ValidationsController::class, 'index'])->name('validation.index');

    //Route::post('/tickets/validate', [TicketController::class, 'validateTicket'])->name('tickets.validate');
    //Route::get('/tickets/invalidate/{ticket}', [TicketController::class, 'invalidate'])->name('tickets.invalidate');
    //Route::get('/tickets/grant-access/{ticket}', [TicketController::class, 'grantAccess'])->name('tickets.grantAccess');

});

/* ----- OTHER PUBLIC ROUTES ----- */

// Use Cart routes should be accessible to the public */
Route::middleware('can:use-cart')->group(function () {
    // Add a ticket to the cart:
    Route::post('cart/{ticket}', [CartController::class, 'addToCart'])->name('cart.add');
    // Remove a ticket from the cart:
    Route::delete('cart/{ticket}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
    // Confirm the cart:
    Route::post('cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');
});


Route::get('/', [MoviesController::class, 'index']);


Route::resource('movies', MoviesController::class)->only(['index', 'show']);
Route::resource('screenings', ScreeningsController::class)->only(['index', 'show']);    

Route::patch('/users/{user}', [UsersController::class, 'block'])->name('users.block');

require __DIR__.'/auth.php';