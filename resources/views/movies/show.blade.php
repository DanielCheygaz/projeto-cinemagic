@extends('layouts.main')

@section('header-title', $movie->title)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    @can('create', App\Models\Movie::class)
                    <x-button
                        href="{{ route('movies.create', ['movie' => $movie]) }}"
                        text="New"
                        type="success"/>
                    @endcan
                    @can('update', $movie)
                    <x-button
                        href="{{ route('movies.edit', ['movie' => $movie]) }}"
                        text="Edit"
                        type="primary"/>
                    @endcan
                    @can('delete', $movie)
                    <form method="POST" action="{{ route('movies.destroy', ['movie' => $movie]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="danger"/>
                    </form>
                    @endcan
                </div>
                <header>
                    <h2 class="text-2xl font-medium text-gray-900 dark:text-gray-100">
                        "{{ $movie->title }}"
                    </h2>
                </header>
                <div class="mt-6 space-y-4">
                    @include('movies.shared.fields', ['mode' => 'show'])
                </div>
                    @php
                    if(isset($screenings[0]->id)){
                        print(' <div class="flex flex-col">
                                    <div class="mt-6 text-4xl text-gray-900 dark:text-gray-100">Sessions:</div>
                                    <div class="mt-3 ms-4 text-lg text-gray-900 dark:text-gray-300">Theater - '. $screenings[0]->theater->name .'</div>
                                </div>
                                <div class="flex flex-row flex-wrap">');
                        $dates = array();
                        foreach ($screenings as $screening) {
                            array_push($dates, $screening->date);
                        }
                        $datesSorted = array_unique($dates);

                        foreach ($datesSorted as $date) {
                            print('<div class="flex flex-col flex-start text-center	mt-7 me-6 text-gray-900 dark:text-gray-100">'. date('l', strtotime($date)) . ' - ' . date('d/m', strtotime($date)));
                            foreach ($screenings as $screening){
                                if ($date == $screening->date) {
                                    print('<a class="text-sm mt-5 ms-2 text-indigo-700 dark:text-indigo-200" href="/cart/add/'. $movie->id .'/'. $screening->theater->id .'/'. $date .'">'. $screening->start_time . '</a>');
                                }
                            }
                            print('</div>');
                        }
                        print('</div>');
                    }
                    @endphp
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
