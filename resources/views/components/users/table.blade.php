<div {{ $attributes }}>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left">Name</th>
            <th class="px-2 py-2 text-left hidden xl:table-cell">Email</th>
            <th class="px-2 py-2 text-left hidden xl:table-cell">Verified Email</th>
            <th class="px-2 py-2 text-left hidden md:table-cell">User Type</th>
            @if($showBlock)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500">
                <td class="px-2 py-2 text-left">{{ $user->name }}</td>
                <td class="px-2 py-2 text-left hidden xl:table-cell">{{ $user->email }}</td>
                <td class="px-2 py-2 text-center hidden xl:table-cell">{{ $user->email_verified_at ? 'Yes':'No' }}</td>
                <td class="px-2 py-2 text-left hidden md:table-cell">{{ $user->user_type }}</td>
                @if($showBlock)
                    <td class="text-center">
                        <x-table.icon-block class="ps-3 px-0.5 {{ $user->blocked ? 'fill-red-600':'fill-gray-100 hover:fill-red-600' }}"
                        action="{{ route('users.block', ['user' => $user]) }}"/>
                    </td>
                @endif
                @if($showDelete)
                    <td>
                        <x-table.icon-delete class="px-0.5"
                        action="{{ route('users.destroy', ['user' => $user]) }}"/>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
