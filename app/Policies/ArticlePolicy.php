<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laravel\Jetstream\Role;

class ArticlePolicy extends ApiPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        if ($user->tokenCan('article:create')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function update(User $user, Article $article): bool
    {
        if ($user->id === $article->author_id) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function delete(User $user, Article $article): bool
    {
        if ($user->id === $article->author_id) {
            return true;
        }
        return false;
    }
}
