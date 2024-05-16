<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

//Route::get('movies', [MovieController::class, 'index']);

Route::resource('movies', MovieController::class);
