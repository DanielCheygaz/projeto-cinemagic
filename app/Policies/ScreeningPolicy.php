<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Screening;

class ScreeningPolicy
{
    public function viewAny(?User $user): bool
    {
        if($user->type == 'E'){
            return false;
        }
        return true;
    }

    public function view(?User $user, Screening $Screening): bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function create(User $user): bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function update(User $user,Screening $Screening):bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function delete(User $user,Screening $Screening):bool
    {
        return $user->admin || $user->type == 'A';
    }
}
