@extends('layouts.app')

@section('content')
    <h1>Tickets</h1>
    <a href="{{ route('tickets.create') }}">Create Ticket</a>
    <ul>
        @foreach ($tickets as $ticket)
            <li>
                <a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->id }}</a>
                <a href="{{ route('tickets.edit', $ticket->id) }}">Edit</a>
                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
