<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MovieFormRequest;
use App\Models\Genre;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MoviesController extends \Illuminate\Routing\Controller
{

    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Movie::class);
    }

    public function index(Request $request): View
    {
        $allGenres = Genre::orderBy('name')->pluck('name','code')->toArray();
        $allGenres = array_merge([''=>'Any Genre'], $allGenres);


        $filterByGenre = $request->query('genre');
        $filterByTitle = $request->query('title');
        $moviesQuery=Movie::query();
        if($filterByGenre !== null){
            $moviesQuery->where('genre_code', $filterByGenre);
        }
        if($filterByTitle !== null){
            $moviesQuery->where('title','like',"%$filterByTitle%");
        }

        $movies = $moviesQuery->orderBy('title')->whereNull('deleted_at')->paginate(20)->withQueryString();
        return view('movies.index',compact('allGenres', 'movies', 'filterByGenre', 'filterByTitle'));
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

    public function store(MovieFormRequest $request): RedirectResponse
    {
        $newMovie = Movie::create($request->validated());
        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->name}</u></a> ({$newMovie}) has been created successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
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
        /* = Screening::query()
        ->with('movieRef')
        ->where('movie_id',$movie->id)
        ->whereBetween('date',[date("Y-m-d"), date('Y-m-d', strtotime('+2 weeks'))])
        ->get();*/

        $screenings = Screening::query()
            ->with('movieRef')
            ->where('movie_id', $movie->id)
            ->whereBetween('date',[date("Y-m-d"), date('Y-m-d', strtotime('+2 weeks'))])
            ->get();


        //$movies=Movie::whereIntegerInRaw('id',$idMovies)->get();

        return view('movies.show',['movie' => $movie,'screenings' => $screenings]);
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        $movieToDelete= Movie::find($movie->id);

        if($movieToDelete) {
            $movieToDelete->deleted_at= date("Y-m-d H:i:s");
            $movieToDelete->save();
        }

        $htmlMessage = "Movie <u>{$movie->title}</u> has been deleted successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
