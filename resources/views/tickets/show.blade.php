@extends('layouts.app')

@section('content')
    <h1>Ticket Details</h1>
    <p>Screening ID: {{ $ticket->screening_id }}</p>
    <p>Seat ID: {{ $ticket->seat_id }}</p>
    <p>Purchase ID: {{ $ticket->purchase_id }}</p>
    <p>Price: {{ $ticket->price }}</p>
    <p>QR Code URL: {{ $ticket->qrcode_url }}</p>
    <p>Status: {{ $ticket->status }}</p>
    <a href="{{ route('tickets.index') }}">Back to list</a>
@endsection
