<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\ScreeningsController;

Route::get('/', [MoviesController::class, 'index']);

Route::resource('movies', MoviesController::class);
Route::resource('screenings', ScreeningsController::class);
