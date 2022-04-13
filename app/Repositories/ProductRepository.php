<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\FilterParamsEnum;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    public function getProducts(int $perPage, array $params)
    {
        $query = Product::with('categories')->when(
            empty($params) || !isset($params[FilterParamsEnum::PUBLISHED]),
            static fn(Builder $query) => $query->published()
        );

        $this->setFilters($params, $query);

        return $query->simplePaginate($perPage)->appends($params);
    }

    public function create(array $data): Product
    {
        $product = Product::create($data);
        $this->attachCategories($product, $data['categories']);
        return $product;
    }

    public function deleteById(int $productId): bool
    {
        return (bool)Product::where('id', $productId)->delete();
    }

    public function update(Product $product, array $data): bool
    {
        $updated = $product->update($data);
        $this->attachCategories($product, $data['categories']);
        return $updated;
    }

    public function attachCategories(Product $product, array $categoriesIds): void
    {
        $product->categories()->attach($categoriesIds);
    }

    public function getById(int $productId): ?Product
    {
        return Product::with('categories')
            ->find($productId);
    }

    private function setFilters(array $params, Builder $query): void
    {
        foreach ($params as $key => $param) {
            if ($key === FilterParamsEnum::CATEGORY_NAME && isset($params[FilterParamsEnum::CATEGORY_ID])) {
                continue;
            }

            match ($key) {
                FilterParamsEnum::NAME => $this->filterByName($query, $param),
                FilterParamsEnum::CATEGORY_ID => $this->filterByCategoryId($query, (int)$param),
                FilterParamsEnum::CATEGORY_NAME => $this->filterByCategoryName($query, $param),
                FilterParamsEnum::PRICE_FROM => $this->filterByPriceFrom($query, (int)$param),
                FilterParamsEnum::PRICE_TO => $this->filterByPriceTo($query, (int)$param),
                FilterParamsEnum::PUBLISHED => $this->filterByPublished($query, (bool)($param)),
                FilterParamsEnum::REMOVED => $this->filterByRemoved($query, (bool)$param),
            };
        }
    }

    private function filterByName(Builder $query, ?string $param): Builder
    {
        return $query->where('name', 'like', "%$param%");
    }

    private function filterByCategoryId(Builder $query, ?int $param): Builder
    {
        return $query->whereHas(
            'categories',
            static fn(Builder $query) => $query->where('id', $param)
        );
    }

    private function filterByCategoryName(Builder $query, string $param): Builder
    {
        return $query->whereHas(
            'categories',
            static fn(Builder $query) => $query
                ->where('name', 'like', "%$param%")
        );
    }

    private function filterByPriceFrom(Builder $query, int $param): Builder
    {
        return $query->where('price', '>=', $param);
    }

    private function filterByPriceTo(Builder $query, int $param): Builder
    {
        return $query->where('price', '<=', $param);
    }

    private function filterByPublished(Builder $query, bool $param): Builder
    {
        return $query->where('published', $param);
    }

    private function filterByRemoved(Builder $query, bool $param): Builder
    {
        return $query->when($param, static fn(Builder $query) => $query->onlyTrashed());
    }
}
