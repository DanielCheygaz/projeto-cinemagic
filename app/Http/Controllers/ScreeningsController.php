<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Movie;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\DB;

class ScreeningsController extends Controller
{
    public function indexOld(Request $request): View
    {
        /*$screenings = Screening::orderBy(Movie->title)->paginate(20);
        return view('screenings.index')->with('screenings', $screenings);*/
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
        $id = Screening::query()
            ->with('screeningRef')
            ->whereBetween('date',[date("Y-m-d"), date('Y-m-d', strtotime('+2 weeks'))])
            ->select('id')
            ->distinct()
            ->pluck('id')
            ->toArray();

        $screenings=Screening::whereIntegerInRaw('id',$id)->get();

        return view('screenings.index', compact('screenings'));
    }

    public function showOld(Movie $movie): View
    {

        $screeningsQuery = Screening::query();
        $allScreenings = $screeningsQuery
            ->where('movie_id',$movie->id)
            ->whereBetween('date',[date("Y-m-d"), date('Y-m-d', strtotime('+2 weeks'))])
            ->get();

        return view('screenings.show', compact('allScreenings'));
    }

    public function show(Screening $screening): View
    {
        dd($screening);
        return view('screenings.show')->with('movie', $screening);
    }

    public function create(): View
    {
        $newScreening = new Screening();
        return view('screenings.create')->with('screening', $newScreening);
    }
}
