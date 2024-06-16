@extends('layouts.main')
@section('header-title', 'Ticket Details')
@section('main')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Ticket Details
            </div>
            <div class="card-body">
                <h5 class="card-title">Customer Name: {{ $ticket->customer_name }}</h5>
                <img src="{{ $ticket->customer_photo_url }}" alt="Customer Photo">
                <p class="card-text">Ticket ID: {{ $ticket->id }}</p>
                <!-- Additional ticket details as needed -->
                <a href="{{ route('tickets.invalidate', ['ticket' => $ticket]) }}" class="btn btn-danger">Invalidate Ticket</a>
                <!-- Button to grant access -->
                <a href="{{ route('tickets.grantAccess', ['ticket' => $ticket]) }}" class="btn btn-success">Grant Access</a>
            </div>
        </div>
    </div>
@endsection
