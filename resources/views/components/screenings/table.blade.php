<div {{ $attributes }}>
    <table class="w-full table-auto border-collapse dark:text-gray-100">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">Title</th>
            <th class="px-2 py-2 text-left">Theater</th>
            <th class="px-2 py-2 text-left">Date</th>
            <th class="px-2 py-2 text-left">Start Time</th>
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
                <td class="px-2 py-2 text-left">{{ $screening->movie_id }}</td>
                <td class="px-2 py-2 text-left">{{ $screening->theater }}</td>
                <td class="px-2 py-2 text-left">{{ $screening->date }}</td>
                <td class="px-2 py-2 text-left">{{ $screening->start_time }}</td>
                @if($showView)
                    <td>
                        <x-table.icon-show class="ps-3 px-0.5"
                        href="{{ route('screenings.show', ['screening' => $screening]) }}"/>
                    </td>
                @endif
                @if($showEdit)
                    <td>
                        <x-table.icon-edit class="px-0.5"
                        href="{{ route('screenings.edit', ['screening' => $screening]) }}"/>
                    </td>
                @endif
                @if($showDelete)
                    <td>
                        <x-table.icon-delete class="px-0.5"
                        action="{{ route('screenings.destroy', ['screening' => $screening]) }}"/>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
