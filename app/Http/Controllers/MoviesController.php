<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MovieFormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
    public function index(): View
    {
        $allMovies = Movie::orderBy('title')->paginate(20);
        return view('movies.index')->with('allMovies', $allMovies);
    }

    public function showCase(): View
    {
        return view('movies.showcase');
    }

    public function create(): View
    {
        $newMovie = new Movie();
        return view('movies.create')->with('movie', $newMovie);
    }

    public function edit(Movie $movie): View
    {
        return view('movies.edit')->with('movie', $movie);
    }

    public function update(movieFormRequest $request, movie $movie): RedirectResponse
    {
        $movie->update($request->validated());
        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "movie <a href='$url'><u>{$movie->name}</u></a> ({$movie->abbreviation}) has been updated successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
    

    public function show(Movie $movie): View
    {
        $screenings = Screening::query()
            ->with('movieRef')
            ->where('movie_id',$movie->id)
            ->whereBetween('date',[date("Y-m-d"), date('Y-m-d', strtotime('+2 weeks'))])
            ->get();

        //$movies=Movie::whereIntegerInRaw('id',$idMovies)->get();

        return view('movies.show',['movie' => $movie,'screenings' => $screenings]);
    }
}
