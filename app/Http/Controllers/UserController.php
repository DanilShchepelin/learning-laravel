<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = User::select('id', 'name')->paginate(5);

        return response()->json([
            'users' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->all());

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        return response()->json([
            'users' => User::all()->where('slug', '=', $slug)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function edit(User $user): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(StoreUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->all());

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
