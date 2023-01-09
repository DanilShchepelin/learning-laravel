<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;
use Illuminate\Http\Request;

class GetList extends Controller
{
    public function __invoke(Request $request): ArticleCollection
    {
        $articles = Article::query()
            ->filtering($request)
            ->sorting($request->query('sort'))
            ->addRelations($request->query('with'))
            ->paginate($request->query('per_page', 5));

        return new ArticleCollection($articles);
    }
}
