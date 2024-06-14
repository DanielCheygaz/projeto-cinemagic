<?php

namespace App\Policies;

use App\Models\User;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User $employee): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->admin || $user->type == 'E';  // Only admin or employee can create employee
    }

    public function update(User $user, User $employee): bool
    {
        return $user->admin || $user->type == 'E'  || ($user->type == 'E' && $user->id == $employee->user_id) ; // Only admin or employee can update employee
    }

    public function delete(User $user, User $employee): bool
    {
        return $user->admin || $user->type == 'E'; // Only admin or employee can delete employee
    }
}
