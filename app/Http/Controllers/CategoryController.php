<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $per_page = $request->get('per_page', 5);
        $categories = Category::paginate($per_page);

        return response()->json([
            'categories' => $categories
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
            'description' => 'required',
        ]);

        $category = Category::create($request->all());

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
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
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $category->update($request->all());

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
