<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TheaterFormRequest;
use App\Models\Seat;
use Carbon\Carbon;



class TheatersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Theater::class);
    }
    public function index(): View
    {
      $allTheaters = Theater::orderBy('name')->whereNull('deleted_at')->paginate(20);
      return view('theaters.index')->with('allTheaters', $allTheaters);
    }

    public function create(): View
    {
        $newTheater = new Theater();
        return view('theaters.create')->with('theater', $newTheater);
    }

    public function store(TheaterFormRequest $request): RedirectResponse
    {
        $this->authorize('create', Theater::class);

        $theater = Theater::create($request->validated());

        $rows = $request->input('rows');
        $seatsPerRow = $request->input('seats_per_row');

        // Create new seats
        $this->createSeats($theater, $rows, $seatsPerRow);

        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Theater <u>{$theater->name}</u> has been created successfully!");
    }

    private function createSeats(Theater $theater, int $rows, int $seatsPerRow)
    {
        for ($row = 1; $row <= $rows; $row++) {
            for ($seatNumber = 1; $seatNumber <= $seatsPerRow; $seatNumber++) {
                Seat::create([
                    'theater_id' => $theater->id,
                    'row' => $row,
                    'seat_number' => $seatNumber,
                ]);
            }
        }
    }

    public function edit(Theater $theater): View
    {
        return view('theaters.edit')->with('theater', $theater);
    }


    public function update(TheaterFormRequest $request, Theater $theater): RedirectResponse
    {
        $theater->update($request->validated());
        $url = route('theaters.show', ['theater' => $theater]);
        $htmlMessage = "theater <a href='$url'><u>{$theater->name}</u></a> ({$theater->abbreviation}) has been updated successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function show(Theater $theater): View
    {
        $theater->load('seat');
        $rows = Seat::query()
        ->select('row')
        ->where('theater_id',$theater->id)
        ->distinct()
        ->pluck('row')
        ->toArray();


        $seatNumbers = Seat::query()
        ->select('seat_number')
        ->where('theater_id',$theater->id)
        ->distinct()
        ->pluck('seat_number')
        ->toArray();

        return view('theaters.show',['theater' => $theater, 'rows' => $rows, 'seatNumbers' => $seatNumbers]);
    }

    public function destroy(Theater $theater): RedirectResponse
    {
        $theaterToDelete= Theater::find($theater->id);

        if($theaterToDelete) {
            $theaterToDelete->deleted_at= date("Y-m-d H:i:s");
            $theaterToDelete->save();
        }

        $htmlMessage = "theater <u>{$theater->name}</u> has been deleted successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

}
