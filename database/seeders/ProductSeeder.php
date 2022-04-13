<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesIds = Category::all('id')->pluck('id')->all();

        Product::factory()
            ->count(300)
            ->create()
            ->each(static function (Product $product) use ($categoriesIds) {
                shuffle($categoriesIds);
                $product->categories()->attach(array_slice($categoriesIds, 0, rand(2, 10)));
            });
    }
}
