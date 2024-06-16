<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Purchase;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\Theater;
use App\Models\Screening;
use App\Models\Seat;

class StatisticsController extends Controller
{
    public function __construct()
    {
        // Aplicar autorização para o recurso Movie não é necessário para a página de estatísticas
        // $this->authorizeResource(Movie::class);
    }

    public function index(): View
    {
        // Chame os métodos para calcular os dados estatísticos
        $ticketsSold = Ticket::count();
        $overallOccupancy = $this->calculateOverallOccupancy();
        $ticketsByMovie = $this->ticketsByMovie();
        $ticketsByMonth = $this->ticketsByMonth();
        $ticketsByDayOfWeek = $this->ticketsByDayOfWeek();
        $purchases = Purchase::with('ticket')->get();

        // Retorne a view 'statistics.index' passando os dados necessários
        return view('statistics.index', [
            'ticketsSold' => $ticketsSold,
            'overallOccupancy' => $overallOccupancy,
            'ticketsByMovie' => $ticketsByMovie,
            'ticketsByMonth' => $ticketsByMonth,
            'ticketsByDayOfWeek' => $ticketsByDayOfWeek,
            'purchases' => $purchases,
        ]);
    }

    // Métodos protegidos para cálculos estatísticos
    protected function calculateOverallOccupancy()
    {
        // Implemente a lógica para calcular a ocupação geral
        $occupiedSeats = Ticket::sum('id');
        $totalSeats = Seat::sum('id');
        $overallOccupancy = ($occupiedSeats / $totalSeats) * 100;

        return $overallOccupancy;
    }

    protected function ticketsByMovie()
    {
    // Obtém todos os filmes com a contagem de ingressos vendidos
    $movies = Screening::select( 'movie_id')
        ->withCount(['tickets' => function ($query) {
            $query->selectRaw('sum(quantity) as tickets_count')
                ->groupBy('movie_id');
        }])
        ->get();

    // Converte a coleção de filmes para um array associativo
    $ticketsByMovie = $movies->mapWithKeys(function ($movie) {
        return [$movie->title => $movie->tickets_count];
    });

    return $ticketsByMovie;
    }

    protected function ticketsByMonth()
    {
        // Implemente a lógica para obter os ingressos vendidos por mês
        return Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
    }

    protected function ticketsByDayOfWeek()
    {
        // Implemente a lógica para obter os ingressos vendidos por dia da semana
        return Ticket::selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->get()
            ->pluck('count', 'day')
            ->toArray();
    }
}
