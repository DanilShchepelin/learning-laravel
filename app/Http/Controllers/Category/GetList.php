<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetList extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $categories = Category::paginate($request->query('per_page', 5));

        return CategoryResource::collection($categories);
    }
}
