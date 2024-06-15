<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Ticket;

class CartPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Ticket $ticket): bool
    {
        return $user->type == 'C' || $user->type == null;
    }

}
