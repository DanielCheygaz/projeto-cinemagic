@extends('layouts.app')

@section('content')
    <h1>Create Ticket</h1>
    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf
        <label for="screening_id">Screening ID:</label>
        <input type="text" name="screening_id" id="screening_id">
        <label for="seat_id">Seat ID:</label>
        <input type="text" name="seat_id" id="seat_id">
        <label for="purchase_id">Purchase ID:</label>
        <input type="text" name="purchase_id" id="purchase_id">
        <label for="price">Price:</label>
        <input type="text" name="price" id="price">
        <label for="qrcode_url">QR Code URL:</label>
        <input type="text" name="qrcode_url" id="qrcode_url">
        <label for="status">Status:</label>
        <input type="text" name="status" id="status">
        <button type="submit">Create</button>
    </form>
@endsection
