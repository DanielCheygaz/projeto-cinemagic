<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\View\View;

class GenresController extends Controller
{
    public function index(): View
    {
        $genres = Genre::orderBy('title')->paginate(20);
        return view('movies.index')->with('genres', $genres);
    }
}
