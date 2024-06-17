<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
{
    use HandlesAuthorization;
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Movie $movie): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function update(User $user, Movie $movie):bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function delete(User $user, Movie $movie):bool
    {
        return $user->admin || $user->type == 'A';
    }
}
