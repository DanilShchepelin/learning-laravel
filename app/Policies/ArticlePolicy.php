<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
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

    public function create(User $user): bool
    {
        if (!$user->tokenCan(Roles::Author->getName()) && !$user->isAdmin()) {
            return false;
        }
        return true;
    }

    public function update (User $user, Article $article): bool
    {
        if ($user->id !== $article->author_id || !$user->isAdmin()) {
            return false;
        }
        return true;
    }

    public function delete (User $user, Article $article): bool
    {
        if ($user->id !== $article->author_id || !$user->isAdmin()) {
            return false;
        }
        return true;
    }
}
