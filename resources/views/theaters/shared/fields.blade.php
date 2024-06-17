@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <div class="flex space-x-4">
            <x-field.input name="name" label="Name" :readonly="$readonly"
                            value="{{ old('name', $theater->name) }}"/>
        </div>
    </div>
    <div class="pb-6" >
        <x-field.image
            name="photo_filename"
            label="Theater Image"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Image"
            :deleteAllow="($mode == 'edit') && ($theater->imageExists)"
            deleteForm="form_to_delete_image"
            :imageUrl="$theater->imageUrl"/>
    </div>
</div>
