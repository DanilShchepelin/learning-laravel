<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\ShowArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class Detail extends Controller
{
    public function __invoke(Article $article, ShowArticleRequest $request): ArticleResource
    {
        $with = $request->validated('with');

        if (!empty($with)) {
            $article->load($with);
        }

        return new ArticleResource($article);
    }
}
