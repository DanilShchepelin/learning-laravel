<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Store extends Controller
{
    public function __invoke(StoreArticleRequest $request): JsonResponse
    {
        $user = auth()->user();

        $article = Article::create([
            'title' => $request->validated('title'),
            'text' => $request->validated('text'),
            'author_id' => $user->id
        ]);
        $categories = $request->input('categories');
        $article->categories()->attach($categories);

        return response()->json([
            'message' => 'Article created successfully',
            'article' => $article
        ], 201);
    }
}
