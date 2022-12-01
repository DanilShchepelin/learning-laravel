<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
