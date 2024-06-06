@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
    <div class="flex space-x-4">
            <x-field.input name="movie" label="Movie" :readonly="$readonly"
                            value="{{ old('movie', $screening->movie->title) }}"/>
            <x-field.input name="theater" label="Theater" :readonly="$readonly"
                            value="{{ old('theater', $screening->theater) }}"/>
        </div>
        <x-field.input name="date" label="Date" :readonly="$readonly"
                    value="{{ old('date', $screening->date) }}"/>
        <x-field.input name="start_time" label="Start Time" :readonly="$readonly"
                    value="{{ old('start_time', $screening->start_time) }}"/>
    </div>
</div>
