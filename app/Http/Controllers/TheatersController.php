<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TheaterFormRequest;
use Carbon\Carbon;



class TheatersController extends Controller
{
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
        return view('theaters.show',['theater' => $theater]);
    }
    public function destroy(Theater $theater): RedirectResponse
    {
        $theaterToDelete= Theater::find($theater->id);

        if($theaterToDelete) {
            $theaterToDelete->deleted_at= date("Y-m-d H:i:s");
            $theaterToDelete->save();
        }

        $htmlMessage = "theater <u>{$theater->name}</u> has been updated successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

}
