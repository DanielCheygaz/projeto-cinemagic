@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Statistics</h1>
    <div id="statistics"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('statistics.data') }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('statistics').innerHTML = `
                <h2>Tickets Sold: ${data.ticketsSold}</h2>
                <h2>Overall Occupancy: ${data.overallOccupancy}%</h2>
                <h2>Tickets Sold by Movie:</h2>
                <ul>${data.ticketsByMovie.map(movie => `<li>${movie.name}: ${movie.count}</li>`).join('')}</ul>
                <h2>Tickets Sold by Month:</h2>
                <ul>${data.ticketsByMonth.map(month => `<li>${month.name}: ${month.count}</li>`).join('')}</ul>
                <h2>Tickets Sold by Day of the Week:</h2>
                <ul>${data.ticketsByDayOfWeek.map(day => `<li>${day.name}: ${day.count}</li>`).join('')}</ul>
                <h2>All Purchases:</h2>
                <ul>${data.purchases.map(purchase => `
                    <li>
                        Purchase #${purchase.id} - ${purchase.created_at} 
                        <ul>${purchase.tickets.map(ticket => `<li>Ticket #${ticket.id} - ${ticket.movie.title}</li>`).join('')}</ul>
                    </li>`).join('')}</ul>
            `;
        })
        .catch(error => console.error('Error:', error));
});
</script>
@endsection
