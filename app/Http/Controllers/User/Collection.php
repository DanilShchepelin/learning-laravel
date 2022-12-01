<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class Collection extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return UserCollection
     */
    public function __invoke(Request $request): UserCollection
    {
        /** @var User $users */
        $users = User::query();

        $users =
            $users->findAuthor($request->query('name'))
                ->paginate($request->query('per_page', 5));

        return new UserCollection($users);
    }
}
