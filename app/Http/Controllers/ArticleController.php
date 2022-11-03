<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\Resource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return ArticleCollection
     */
    public function index(Request $request): ArticleCollection
    {

        $articles = Article::query()
            ->filtering($request)
            ->sorting($request->query('sort'))
            ->addRelations($request->query('with'))
            ->paginate($request->query('per_page', 5));

        return new ArticleCollection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticleRequest $request
     * @return JsonResponse
     */
    public function store(StoreArticleRequest $request): JsonResponse
    {
        $article = Article::create($request->validated());
        $categories = $request->input('categories');
        $article->categories()->attach($categories);

        return response()->json([
            'message' => 'Article created successfully',
            'article' => $article
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @param Request $request
     * @return ArticleResource
     */
    public function show(Article $article, Request $request): ArticleResource
    {
        // todo добавить валидации с описанием возможных параметров. Например with

        $with = $request->query('with');
        if (!empty($with)) {
            $article->load($with);
        }

//        return new ArticleResource($article, Resource::FULL_FORM);
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Article $article
     * @return JsonResponse
     */
    public function update(Request $request, Article $article): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'string',
            'text' => 'string',
            'author_id' => 'exists:App\Models\User,id'
        ]);

        $article->update($validated);

        return response()->json([
            'message' => 'Article updated successfully',
            'article' => $article
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse
    {
        $article->delete();

        return response()->json([
            'message' => 'Article deleted successfully'
        ], 204);
    }
}
