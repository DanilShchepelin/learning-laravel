<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class Store extends Controller
{
    public function __invoke(StoreArticleRequest $request): JsonResponse
    {
        $article = Article::create([
            'title' => $request->validated('title'),
            'text' => $request->validated('text'),
            'author_id' => $request->user()->id
        ]);

        $article
            ->categories()
            ->attach($request->input('categories'));

        return response()->json([
            'message' => 'Article created successfully',
            'article' => $article
        ], 201);
    }
}
