<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\Article\ShowArticleRequest;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Client\HttpClientException;
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
        $user = auth('sanctum')->user();

        if (!$user->tokenCan(Roles::Admin->getName())) {
            return response()->json([
                'message' => 'У вас недостаточно прав'
            ], 403);
        }

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
     * @param ShowArticleRequest $request
     * @return ArticleResource
     * @throws HttpClientException
     */
    public function show(Article $article, ShowArticleRequest $request): ArticleResource
    {
        $with = $request->validated('with');

        if (!empty($with)) {
            if (!in_array(null, $with)) {
                $article->load($with);
            } else {
                throw new HttpClientException('Параметр with должен быть заполнен');
            }
        }

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return JsonResponse
     */
    public function update(UpdateArticleRequest $request, Article $article): JsonResponse
    {
        $user = auth('sanctum')->user();

        if (!$user->tokenCan(Roles::Author->getName())) {
            return response()->json([
                'message' => 'У вас недостаточно прав'
            ], 403);
        }

        if ($user->id !== $article->author_id) {
            return response()->json([
                'message' => 'Вы не являетесь автором статьи'
            ], 403);
        }

        $article->update($request->validated());

        return response()->json([
            'message' => 'Article updated successfully',
            'article' => $article
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse
    {
        $user = auth('sanctum')->user();

        if (!$user->tokenCan(Roles::Author->getName())) {
            return response()->json([
                'message' => 'У вас недостаточно прав'
            ], 403);
        }

        if ($user->id !== $article->author_id) {
            return response()->json([
                'message' => 'Вы не являетесь автором статьи'
            ], 403);
        }
//        if(User::isAuthorOrAdmin($user, $article)) {
//            $article->delete();
//        }

        $article->delete();

        return response()->json([
            'message' => 'Article deleted successfully'
        ], 204);
    }
}
