<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Update extends Controller
{
    public function __invoke(UpdateArticleRequest $request, Article $article): JsonResponse
    {
        $article->update($request->validated());

        return response()->json([
            'message' => 'Article updated successfully',
            'article' => $article
        ]);
    }
}
