<?php

namespace App\Http\Requests;

use App\Dto\CategoryDto;

class CategoryRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => "required|string|min:3|max:255|unique:categories,name,{$this->category->id}"
        ];
    }

    public function toDto(): CategoryDto
    {
        return new CategoryDto($this->input('name'));
    }
}
