<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class Update extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function __invoke(UpdateUserRequest $request, User $user): JsonResponse
    {
        $current_user = $request->user();

        if ($current_user->cannot('update', $user)) {
            return response()->json([
                'message' => 'У вас недостаточно прав'
            ], 403);
        }

        $user->update($request->validated());

        if ($request->hasFile('image')) {
            $user->clearMediaCollection('profile_picture');
            $user->addMediaFromRequest('image')->toMediaCollection('profile_picture');
        }


        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }
}
