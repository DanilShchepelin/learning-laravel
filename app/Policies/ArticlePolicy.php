<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy extends ApiPolicy
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
        if (!$user->tokenCan(Roles::Author->getName()) && !$user->isAdmin()) {
            return false;
        }
        return true;
    }

    /**
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function update(User $user, Article $article): bool
    {
        if ($user->id !== $article->author_id) {
            return false;
        }
        return true;
    }

    /**
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function delete(User $user, Article $article): bool
    {
        if ($user->id !== $article->author_id) {
            return false;
        }
        return true;
    }
}
