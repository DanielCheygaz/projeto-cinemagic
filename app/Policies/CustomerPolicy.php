<?php

namespace App\Policies;

use App\Models\User;

class CustomerPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->admin) {
            return true;
        }
        // When "Before" returns null, other methods (eg. viewAny, view, etc...) will be
        // used to check the user authorizaiton
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->type == 'E' || $user->type == 'A';
    }

    public function viewMy(User $user): bool
    {
        return $user->type == 'C';
    }

    public function view(User $user, User $customer): bool
    {
        if ($user->type == 'A' || ($user->type == 'c' && $user->id == $customer->user_id)) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->type == 'A';
    }

    public function update(User $user, User $customer): bool
    {
        if ($user->type == 'A' || ($user->type == 'C' && $user->id == $customer->user_id)) {
            return true;
        }

        return false;
    }

    public function delete(User $user, User $customer): bool
    {
        return $user->type == 'A';
    }
}
