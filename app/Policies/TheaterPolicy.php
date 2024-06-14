<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Theater;

class TheaterPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Theater $theater): bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function create(User $user): bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function update(User $user, Theater $theater):bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function delete(User $user, Theater $theater):bool
    {
        return $user->admin || $user->type == 'A';
    }
}
