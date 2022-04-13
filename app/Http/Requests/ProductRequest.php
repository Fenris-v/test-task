<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Dto\ProductDto;

class ProductRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'published' => 'boolean',
            'categories' => 'required|array|min:2|max:10',
            'categories.*' => 'numeric|integer'
        ];
    }

    public function toDto(): ProductDto
    {
        return new ProductDto(
            $this->input('name'),
            (float)$this->input('price'),
            $this->input('description'),
            (bool)$this->input('published'),
            $this->input('categories')
        );
    }
}
