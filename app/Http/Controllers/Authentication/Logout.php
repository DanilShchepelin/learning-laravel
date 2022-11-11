<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class Logout extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = Auth::user();

        /** @var PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $token->deleteOrFail();

        return response()->json([
            'message' => 'Good bye!!!!!!'
        ]);
    }
}
