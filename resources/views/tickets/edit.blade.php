@extends('layouts.app')

@section('content')
    <h1>Edit Ticket</h1>
    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="screening_id">Screening ID:</label>
        <input type="text" name="screening_id" id="screening_id" value="{{ $ticket->screening_id }}">
        <label for="seat_id">Seat ID:</label>
        <input type="text" name="seat_id" id="seat_id" value="{{ $ticket->seat_id }}">
        <label for="purchase_id">Purchase ID:</label>
        <input type="text" name="purchase_id" id="purchase_id" value="{{ $ticket->purchase_id }}">
        <label for="price">Price:</label>
        <input type="text" name="price" id="price" value="{{ $ticket->price }}">
        <label for="qrcode_url">QR Code URL:</label>
        <input type="text" name="qrcode_url" id="qrcode_url" value="{{ $ticket->qrcode_url }}">
        <label for="status">Status:</label>
        <input type="text" name="status" id="status" value="{{ $ticket->status }}">
        <button type="submit">Update</button>
    </form>
@endsection
