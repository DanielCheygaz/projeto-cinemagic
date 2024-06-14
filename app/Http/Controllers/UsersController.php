<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index(Request $request): View
    {
        $typesArray = User::groupBy('type')->pluck('type')->toArray();
        $typesArray = array_merge(['Any Type'], $typesArray);

        $typeNames = [
            'A' => 'Admin',
            'E' => 'Employee',
            'C' => 'Customer'
        ];

        $types = ['' => 'Any Type',];

        // Populate the associative array with the corresponding names
        foreach ($typesArray as $type) {
            if (array_key_exists($type, $typeNames)) {
                $types[$type] = $typeNames[$type];
            }
        }
        $filterBytype = $request->query('userType');
        $filterByName = $request->query('name');
        $usersQuery = User::query();
        if ($filterBytype !== null) {
            $usersQuery->where('type', $filterBytype);
        }
        if ($filterByName !== null) {
            $usersQuery->where('users.name', 'like', "%$filterByName%");
        }

        $users = $usersQuery
            ->whereNull('deleted_at')
            ->paginate(20)
            ->withQueryString();
        return view(
            'users.index',
            compact('types', 'users', 'filterBytype', 'filterByName')
        );
    }

    public function destroy(User $user): RedirectResponse
    {
        $userToDelete= User::find($user->id);

        if($userToDelete) {
            $userToDelete->deleted_at= date("Y-m-d H:i:s");
            $userToDelete->save();
        }

        $htmlMessage = "User <u>{$user->name}</u> has been updated successfully!";
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function block(User $user) : RedirectResponse {
        $userToBlock= User::find($user->id);

        if($userToBlock) {
            $userToBlock->blocked = 1;
            $userToBlock->save();
        }

        $htmlMessage = "User <u>{$user->name}</u> has been blocked successfully!";
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
