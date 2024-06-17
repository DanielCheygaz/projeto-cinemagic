<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use App\Models\Ticket;

class ValidationsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:view,App\Models\Ticket');
    }
    public function index(): View
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }
}