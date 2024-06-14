@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <div class="flex space-x-4">
            <x-field.input name="year" label="Year" :readonly="$readonly"
                            value="{{ old('year', $movie->year) }}"/>
            <x-field.input name="genre" label="Genre" :readonly="$readonly"
                            value="{{ old('genre', $movie->genreRef->name ?? '') }}"/>
        </div>
        <x-field.input name="trailer_url" label="Trailer URL" :readonly="$readonly"
                    value="{{ old('trailer_url', $movie->trailer_url) }}"/>
        <x-field.text-area name="synopsis" label="Synopsis" :readonly="$readonly"
                            value="{{ old('synopsis', $movie->synopsis) }}"/>
    </div>
    <div class="pb-6">
        <x-field.image
            name="image_file"
            label="Poster Image"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Image"
            :deleteAllow="($mode == 'edit') && ($movie->imageExists)"
            deleteForm="form_to_delete_image"
            :imageUrl="$movie->imageUrl"/>
    </div>
</div>
