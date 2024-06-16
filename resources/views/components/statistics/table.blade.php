<div {{ $attributes }}>
    <h2 class="text-xl font-semibold">Tickets Sold: {{ $ticketsSold }}</h2>
    <h2 class="text-xl font-semibold">Overall Occupancy: {{ $overallOccupancy }}%</h2>

    <h2 class="text-lg font-semibold mt-6">Tickets Sold by Movie:</h2>
    <table class="w-full table-auto border-collapse dark:text-gray-100">
        <thead>
            <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Movie</th>
                <th class="px-2 py-2 text-left">Tickets Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticketsByMovie as $movie)
                <tr class="border-b border-gray-400 dark:border-gray-500">
                    <td class="px-2 py-2 text-left">{{ $movie['name'] }}</td>
                    <td class="px-2 py-2 text-left">{{ $movie['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-lg font-semibold mt-6">Tickets Sold by Month:</h2>
    <table class="w-full table-auto border-collapse dark:text-gray-100">
        <thead>
            <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Month</th>
                <th class="px-2 py-2 text-left">Tickets Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticketsByMonth as $month)
                <tr class="border-b border-gray-400 dark:border-gray-500">
                    <td class="px-2 py-2 text-left">{{ $month['name'] }}</td>
                    <td class="px-2 py-2 text-left">{{ $month['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-lg font-semibold mt-6">Tickets Sold by Day of the Week:</h2>
    <table class="w-full table-auto border-collapse dark:text-gray-100">
        <thead>
            <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Day</th>
                <th class="px-2 py-2 text-left">Tickets Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticketsByDayOfWeek as $day)
                <tr class="border-b border-gray-400 dark:border-gray-500">
                    <td class="px-2 py-2 text-left">{{ $day['name'] }}</td>
                    <td class="px-2 py-2 text-left">{{ $day['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-lg font-semibold mt-6">All Purchases:</h2>
    <table class="w-full table-auto border-collapse dark:text-gray-100">
        <thead>
            <tr class="border-b-2 border-gray-400 dark:border-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-left">Purchase ID</th>
                <th class="px-2 py-2 text-left">Date</th>
                <th class="px-2 py-2 text-left">Tickets</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr class="border-b border-gray-400 dark:border-gray-500">
                    <td class="px-2 py-2 text-left">{{ $purchase['id'] }}</td>
                    <td class="px-2 py-2 text-left">{{ $purchase['created_at'] }}</td>
                    <td class="px-2 py-2 text-left">
                        <ul class="list-disc list-inside">
                            @foreach($purchase['tickets'] as $ticket)
                                <li>Ticket #{{ $ticket['id'] }} - {{ $ticket['movie']['title'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
