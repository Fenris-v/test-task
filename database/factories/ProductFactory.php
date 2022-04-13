<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->numberBetween(500, 1000000),
            'description' => $this->faker->boolean() ? $this->faker->realText(500) : '',
            'published' => $this->faker->boolean(70),
            'created_at' => $this->faker->dateTimeBetween('-3 month', '-2 month'),
            'updated_at' => $this->faker->dateTimeBetween('-2 month', '-1 month'),
            'deleted_at' => $this->faker->boolean(15)
                ? $this->faker->dateTimeBetween('-1 month', '-1 day')
                : null,
        ];
    }
}
