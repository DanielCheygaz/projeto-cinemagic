@extends('layouts.main')

@section('header-title', 'List of Theaters')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
    <div class="flex items-center gap-4 mb-4">
        <x-button
        href="{{ route('theaters.create') }}"
        text="Add a theater"
        type="success"/>
    </div>
    <div class="font-base text-sm text-gray-700 dark:text-gray-300">
        <x-theaters.table :theaters="$allTheaters"
        :showView="true"
        :showEdit="true"
        :showDelete="true"
        />
    </div>
    <div class="mt-4">
                {{ $allTheaters->links() }}
            </div>
        </div>
    </div>
@endsection
