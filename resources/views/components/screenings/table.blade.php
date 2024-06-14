<div {{ $attributes }}>
    <table class="w-full table-auto border-collapse dark:text-gray-100 w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">Title</th>
            <th class="px-2 py-2 hidden text-right lg:table-cell">Genre</th>
            <th class="px-2 py-2 hidden text-right lg:table-cell">Year</th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($screenings as $screening)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $screening->title }}</td>
                <td class="px-2 py-2 hidden text-right lg:table-cell">{{ $screening->genreRef->name }}</td>
                <td class="px-2 py-2 hidden text-right lg:table-cell">{{ $screening->year }}</td>
                @if($showView)
                    <td>
                        <x-table.icon-show class="ps-3 px-0.5"
                        href="{{ route('movies.show', ['movie' => $screening]) }}"/>
                    </td>
                @endif
                @if($showEdit)
                    @can('update', $screening)
                    <td>
                        <x-table.icon-edit class="px-0.5"
                        href="{{ route('screenings.edit', ['screening' => $screening]) }}"/>
                    </td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $screening)
                    <td>
                        <x-table.icon-delete class="px-0.5"
                        action="{{ route('screenings.destroy', ['screening' => $screening]) }}"/>
                    </td>
                    @endcan
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
