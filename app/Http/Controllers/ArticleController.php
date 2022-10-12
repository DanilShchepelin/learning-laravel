<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'articles' => Article::all(),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function show(Article $article): JsonResponse
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonJsonResponse
    {
        //
    }
}
