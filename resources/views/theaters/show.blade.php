@extends('layouts.main')

@section('header-title', $theater->name)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('theaters.create', ['theater' => $theater]) }}"
                        text="New"
                        type="success"/>
                    <x-button
                        href="{{ route('theaters.edit', ['theater' => $theater]) }}"
                        text="Edit"
                        type="primary"/>
                    <form method="POST" action="{{ route('theaters.destroy', ['theater' => $theater]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                </div>
                <header>
                    <h2 class="text-2xl font-medium text-gray-900 dark:text-gray-100">
                        "{{ $theater->name }}"
                    </h2>
                </header>
                <div class="mt-6 space-y-4">
                    <img src="{{ $theater->imageUrl }}" alt="{{ $theater->name }} Poster" class="w-full h-auto">

                    @include('theaters.shared.fields', ['mode' => 'show'])

                    <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100 mt-6">Seats</h3>
                    <div class="mt-4">
                        @if ($theater->seat->isEmpty())
                            <p>No seats available for this theater.</p>
                        @else
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th>Row</th>
                                        <th>Seat Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($theater->seat as $seat)
                                        <tr>
                                            <td>{{ $seat->row }}</td>
                                            <td>{{ $seat->seat_number }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
