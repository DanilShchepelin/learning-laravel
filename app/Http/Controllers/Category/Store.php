<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\JsonResponse;

class Store extends Controller
{
    /**
     * @throws HttpClientException
     */
    public function __invoke(StoreCategoryRequest $request): JsonResponse
    {
        $parent_id = $request->validated('parent_id');

        if (!empty($parent_id)) {
            $parent = Category::find($parent_id);
            if (!empty($parent)) {
                $category = Category::create($request->validated(), $parent);
            } else {
                throw new HttpClientException('Не существует родительской категории с ID: ' . $parent_id);
            }
        }

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category ?? Category::create($request->validated())
        ], 201);
    }
}
