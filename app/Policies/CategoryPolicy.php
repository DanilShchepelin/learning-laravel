<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        if (!$user->isAdmin()) {
            return false;
        }
        return true;
    }

    /**
     * @param Category $category
     * @param User $user
     * @return bool
     */
    public function update(Category $category, User $user): bool
    {
        if (!$user->isAdmin()) {
            return false;
        }
        return true;
    }

    /**
     * @param Category $category
     * @param User $user
     * @return bool
     */
    public function delete(Category $category, User $user): bool
    {
        if (!$user->isAdmin()) {
            return false;
        }
        return true;
    }
}
