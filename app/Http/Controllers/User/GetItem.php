<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\UserResource;
use App\Models\User;

class GetItem extends \App\Http\Controllers\Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function __invoke(User $user): UserResource
    {
        return new UserResource($user);
    }
}
