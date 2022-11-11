<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Me extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return User
     */
    public function __invoke(Request $request): User
    {
        return $request->user();
    }
}
