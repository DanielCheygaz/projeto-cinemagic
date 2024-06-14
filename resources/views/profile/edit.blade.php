@extends('layouts.main')

@section('header-title', 'Profile')

@section('main')
<div class="min-h-screen flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-800">
    <div class="w-full sm:max-w-7xl mt-6 px-6 py-4 bg-white dark:bg-gray-900 shadow-md overflow-hidden sm:rounded-lg">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
                    <div class="flex flex-col lg:flex-row lg:space-x-6 space-y-6 lg:space-y-0">
                        <div class="w-full lg:w-1/2">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                        <div class="w-full lg:w-1/2">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
