@extends('layouts.main')

@section('header-title', 'List of Users')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <x-users.filter-card
                :filterAction="route('users.index')"
                :resetUrl="route('users.index')"
                :usertypes="$types"
                :usertype="old('type', $filterBytype)"
                :name="old('name', $filterByName)"
                class="mb-6"
                />
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-users.table :users="$users"
                    :showBlock="true"
                    :showEdit="true"
                    :showDelete="true"
                    />
            </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
