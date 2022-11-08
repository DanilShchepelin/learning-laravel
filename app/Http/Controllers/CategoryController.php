<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            Category::paginate($request->get('per_page', 5))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     * @throws HttpClientException
     */
    public function store(StoreCategoryRequest $request): JsonResponse
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

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

//        $parent_id = $request->validated('parent_id');
//
//        if (!empty($parent_id)) {
//            $parent = Category::find($parent_id);
//            if (!empty($parent)) {
//                $category->update($request->validated());
//            } else {
//                throw new HttpClientException('Не существует родительской категории с ID: ' . $parent_id);
//            }
//        }

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
