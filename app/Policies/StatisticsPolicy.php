<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatisticsPolicy
{
    use HandlesAuthorization;

    public function viewStatistics(User $user): bool
    {
        return $user->admin || $user->type == 'A';
    }

    
}
