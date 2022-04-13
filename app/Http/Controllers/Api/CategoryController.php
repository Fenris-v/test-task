<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\DestroyCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(CategoryRepository $categoryRepository): JsonResponse
    {
        return response()->json($categoryRepository->all());
    }

    public function store(CategoryRequest $categoryRequest, CategoryRepository $categoryRepository): JsonResponse
    {
        $categoryDto = $categoryRequest->toDto();
        $category = $categoryRepository->create($categoryDto->toArray());

        return response()->json([
            'success' => true,
            'message' => __('api.category.created'),
            'data' => $category
        ]);
    }

    public function show(int $categoryId, CategoryRepository $categoryRepository): JsonResponse
    {
        $category = $categoryRepository->getById($categoryId);
        return response()->json($category);
    }

    public function update(
        Category $category,
        CategoryRequest $categoryRequest,
        CategoryRepository $categoryRepository
    ): JsonResponse {
        $categoryDto = $categoryRequest->toDto();
        $categoryUpdated = $categoryRepository->update($category, $categoryDto->toArray());

        if (!$categoryUpdated) {
            return response()->json([
                'success' => false,
                'message' => __('api.update_error'),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('api.category.updated'),
        ]);
    }

    public function destroy(
        DestroyCategoryRequest $destroyCategoryRequest,
        CategoryRepository $categoryRepository
    ): JsonResponse {
        $categoryId = (int)$destroyCategoryRequest->get('id');
        if (!$categoryRepository->deleteById($categoryId)) {
            return response()->json([
                'success' => false,
                'message' => __('api.delete_error')
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('api.category.deleted'),
        ]);
    }
}
