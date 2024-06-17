@extends('layouts.main')

@section('header-title', 'Movies On Show')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            @can('create', App\Models\Screening::class)
            <div class="flex items-center gap-4 mb-4">
                <x-button
                    href="{{ route('screenings.create') }}"
                    text="Add a screening"
                    type="success"/>
            </div>
            @endcan
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-screenings.table :screenings="$screenings"
                    :showView="true"
                    :showEdit="true"
                    :showDelete="true"
                    />
            </div>
        </div>
    </div>
@endsection
