<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'screening_id' => 'required|integer|exists:screenings,id',
            'seat_id' => 'required|integer|exists:seats,id',
            'purchase_id' => 'required|integer|exists:purchases,id',
            'price' => 'required|numeric',
            'qrcode_url' => 'required|string',
            'status' => 'required|string'
        ]);

        Ticket::create($request->all());

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'screening_id' => 'required|integer|exists:screenings,id',
            'seat_id' => 'required|integer|exists:seats,id',
            'purchase_id' => 'required|integer|exists:purchases,id',
            'price' => 'required|numeric',
            'qrcode_url' => 'required|string',
            'status' => 'required|string'
        ]);

        $ticket->update($request->all());

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
