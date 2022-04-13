<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\FilterParamsEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductRepository $productRepository, Request $request): JsonResponse
    {
        // Задача не предусматривает усложнения. В теории можно было всё сложить в массив и пройтись циклом
        $params = $request->only(FilterParamsEnum::PARAMS);
        $products = $productRepository->getProducts((int)$request->get('perPage'), $params);

        return response()->json($products);
    }

    public function store(ProductRequest $productRequest, ProductRepository $productRepository): JsonResponse
    {
        $productDto = $productRequest->toDto();

        $product = $productRepository->create($productDto->toArray());
        $product->load('categories');

        return response()->json([
            'success' => false,
            'message' => __('api.product.created'),
            'data' => $product
        ]);
    }

    public function show(int $productId, ProductRepository $productRepository): JsonResponse
    {
        $product = $productRepository->getById($productId);
        if ($product === null) {
            return response()->json([
                'success' => false,
                'message' => __('api.not_found'),
            ], 404);
        }

        $product->load('categories');
        return response()->json($product);
    }

    public function update(
        Product $product,
        ProductRequest $productRequest,
        ProductRepository $productRepository
    ): JsonResponse {
        $productDto = $productRequest->toDto();
        $productUpdated = $productRepository->update($product, $productDto->toArray());

        if (!$productUpdated) {
            return response()->json([
                'success' => false,
                'message' => __('api.update_error'),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('api.product.updated'),
        ]);
    }

    public function destroy(int $productId, ProductRepository $productRepository): JsonResponse
    {
        if (!$productRepository->deleteById($productId)) {
            return response()->json([
                'success' => false,
                'message' => __('api.delete_error'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('api.product.deleted'),
        ]);
    }
}
