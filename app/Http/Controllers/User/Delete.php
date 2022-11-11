<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class Delete extends \App\Http\Controllers\Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 204);
    }
}
