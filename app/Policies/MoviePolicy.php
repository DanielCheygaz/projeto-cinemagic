<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;

class MoviePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Movie $movie): bool
    {
        return $user->admin || $user->type == 'A';
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
