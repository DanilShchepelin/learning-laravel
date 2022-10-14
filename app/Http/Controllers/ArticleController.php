<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $per_page = $request->get('per_page', 5);

        $data = $request->all();

        $query = Article::query();

        if (isset($data['title'])) {
            $query->where('title', 'like', "%{$data['title']}%");
        }

        if (isset($data['author'])) {
            $query
                ->where('author_id', $data['author']);
//                ->with([
//                    'users' => function ($query) {
//                        $query->select('users.id', 'users.name');
//                    }
//                ])
//                ->with('author:id,name')
//                ->whereHas('author', function ($query) use ($data) {
//                    return $query->where('id', $data['author']);
//                });
        }

        if (isset($data['category_id'])) {
            $query->with('categories')->whereHas('categories', function ($query) use ($data) {
                return $query->where('category_id', $data['category_id']);
            });
        }

        $articles = $query->paginate($per_page);


        return response()->json([
            $articles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'text' => 'required',
            'author_id' => 'required'
        ]);

        $article = Article::create($request->all());

        $categories_id = Category::all()->pluck('id');

        $article = Article::find($article['id']);

        for (
            $i = 0, $iterations_limit = rand(0, 2);
            $i <= $iterations_limit;
            $i++
        ) {
            $category_id = $categories_id->random();
            $article->categories()->attach($category_id);
        }

        return response()->json([
            'message' => 'Article created successfully',
            'article' => $article
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function show(Article $article): JsonResponse
    {
        return response()->json([
            'article' => $article
        ]);
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
        $article->update($request->all());

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
        ], 200);
    }
}
