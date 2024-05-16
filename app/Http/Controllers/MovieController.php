<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MovieFormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::orderBy('title')->paginate(20);
        return view('movies.index')->with('movies', $movies);
    }

    public function showCase(): View
    {
        return view('courses.showcase');
    }

    public function create(): View
    {
        $newMovie = new Movie();
        return view('movies.create')->with('movie', $newMovie);
    }

    public function show(Movie $movie): View
    {
        return view('movies.show')->with('movie', $movie);
    }
}
