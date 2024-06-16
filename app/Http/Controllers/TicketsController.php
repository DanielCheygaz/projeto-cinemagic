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

    public function validateTicket(Request $request)
    {
        $ticketId = $request->input('ticket_id');
        $qrcodeUrl = $request->input('qrcode_url');

        // Logic to retrieve ticket details based on QR code URL or ticket ID
        if ($qrcodeUrl) {
            $ticket = Ticket::where('qrcode_url', $qrcodeUrl)->first();
        } elseif ($ticketId) {
            $ticket = Ticket::find($ticketId);
        } else {
            return redirect()->back()->with('error', 'Please provide a ticket ID or QR code URL.');
        }

        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found or invalid.');
        }

        // Check if the ticket is associated with the correct screening session
        if (!$this->isValidForScreening($ticket)) {
            return redirect()->back()->with('error', 'Ticket is not valid for this screening session.');
        }

        // Display ticket details to the employee
        return view('tickets.validate', ['ticket' => $ticket]);
    }

    protected function isValidForScreening(Ticket $ticket)
    {
        // Implement your logic to validate if the ticket is for the correct screening session
        // Example: Check screening date, movie, theater, etc.
        // For demonstration, assume the ticket is always valid for now
        return true;
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
