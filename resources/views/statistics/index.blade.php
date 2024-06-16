@extends('layouts.main')

@section('header-title', 'Statistics')
@section('main')
<div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-statistics.table 
                />
            </div>

@endsection
