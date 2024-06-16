<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ValidationsPolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return $user->type == 'E';
    }


}
