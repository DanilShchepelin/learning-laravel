<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Delete extends Controller
{
    public function __invoke(Article $article): JsonResponse
    {
        $user = auth()->user();

        $article->delete();

        return response()->json([
            'message' => 'Article deleted successfully'
        ], 204);
    }
}
