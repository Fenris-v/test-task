<?php

declare(strict_types=1);

namespace App\Dto;

class ProductDto
{
    private string $name;
    private float $price;
    private ?string $description;
    private bool $published;
    private array $categories;

    public function __construct(string $name, float $price, ?string $description, bool $published, array $categories)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->published = $published;
        $this->categories = $categories;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'published' => $this->published,
            'categories' => $this->categories,
        ];
    }
}
