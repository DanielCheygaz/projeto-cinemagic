<?php

namespace App\View\Components\Screenings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public array $listMovies;
    public array $listTheaters;

    public function __construct(
        public array $movies,
        public array $theaters,
        public string $filterAction,
        public string $resetUrl,
        public ?int $movie = null,
        public ?int $theater = null,
    )
    {
        $this->listMovies = (array_merge([null => 'Any movies'], $movies));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.screenings.filter-card');
    }
}
