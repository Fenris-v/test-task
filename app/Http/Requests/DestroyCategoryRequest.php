<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;

class DestroyCategoryRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'numeric|unique:category_product,category_id'
        ];
    }

    public function messages(): array
    {
        return [
            'id.unique' => __('api.validation.category_has_products'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['id' => Route::current()->parameter('category')]);
    }
}
