<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screening;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\DB;

class ScreeningsController extends Controller
{
    public function index(Request $request): View
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
}
