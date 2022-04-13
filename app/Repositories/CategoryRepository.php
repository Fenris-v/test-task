<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function all(): Collection
    {
        return Category::all();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function deleteById(int $categoryId): bool
    {
        return (bool)Category::where('id', $categoryId)->delete();
    }

    public function getById(int $categoryId): ?Category
    {
        return Category::find($categoryId);
    }
}
