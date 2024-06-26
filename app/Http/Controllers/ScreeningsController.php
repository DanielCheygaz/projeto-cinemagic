<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Movie;
use App\Models\Theater;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class ScreeningsController extends Controller
{
    public function indexOld(Request $request): View
    {
        $filterByMovie = $request->input('movie');
        $filterByTheater = $request->query('theater');
        $screeningsQuery = Screening::query();
        if ($filterByMovie !== null) {
            $screeningsQuery->where('movie_id', $filterByMovie);
        }
        if($filterByMovie !== null){
            $screeningsQuery->where('theater_id', $filterByTheater);
        }

        $screenings = $screeningsQuery
            ->with('movieRef')
            ->whereBetween('date',[date("Y-m-d"), date('Y-m-d', strtotime('+2 weeks'))])
            ->orderBy('date')
            ->paginate(20)
            ->withQueryString();
        return view(
            'screenings.index',
            compact('screenings', 'filterByMovie', 'filterByTheater')
        );
    }

    public function index(Request $request): View{
            $idMovies = Screening::query()
            ->whereBetween('date',[date("Y-m-d"), date('Y-m-d', strtotime('+2 weeks'))])
            ->select('movie_id')
            ->distinct()
            ->pluck('movie_id')
            ->toArray();

        $screenings=Movie::whereIntegerInRaw('id',$idMovies)->get();

        return view('screenings.index', compact('screenings'));
    }

    public function show(Movie $movie): View
    {
        return view('screenings.show')->with('movie', $movie);
    }

    public function create(): View
    {
        $newScreening = new Screening();
        return view('screenings.create')->with('screening', $newScreening);
    }
}
