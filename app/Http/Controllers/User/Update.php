<?php

namespace App\Http\Controllers\User;

use App\Enums\MediaCollections;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
        $user->update($request->validated());

        if ($request->hasFile('image')) {
            $user->clearMediaCollection(MediaCollections::PROFILE_PICTURE);
            $user->addMediaFromRequest('image')->toMediaCollection(MediaCollections::PROFILE_PICTURE);
        }

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }
}
