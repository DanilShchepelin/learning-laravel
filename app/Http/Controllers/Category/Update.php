<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\JsonResponse;

class Update extends Controller
{
    /**
     * @throws HttpClientException
     */
    public function __invoke(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $parent_id = $request->validated('parent_id');

        if (!empty($parent_id)) {
            $parent = Category::find($parent_id);
            if (!empty($parent)) {
                $category->update($request->validated());
            } else {
                throw new HttpClientException('Не существует родительской категории с ID: ' . $parent_id);
            }
        }

        $category->update($request->validated());

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ], 200);
    }
}
