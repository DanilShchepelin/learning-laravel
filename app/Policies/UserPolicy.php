<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy extends ApiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        if($user->id !== $model->id) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }

//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param User $user
//     * @param User $model
//     * @return Response|bool
//     */
//    public function restore(User $user, User $model): Response|bool
//    {
//        return Response::deny();
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param User $user
//     * @param User $model
//     * @return Response|bool
//     */
//    public function forceDelete(User $user, User $model): Response|bool
//    {
//        return Response::deny();
//    }
}
