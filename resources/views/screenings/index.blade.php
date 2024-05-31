@extends('layouts.main')

@section('header-title', 'List of Screenings')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="{{ route('screenings.create') }}"
                    text="Add a screening"
                    type="success"/>
            </div>
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-screenings.table :movies="$movies"
                    :showView="true"
                    :showEdit="true"
                    :showDelete="true"
                    />
            </div>
        </div>
    </div>
@endsection
