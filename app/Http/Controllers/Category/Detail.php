<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class Detail extends Controller
{
    public function __invoke(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
}
