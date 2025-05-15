<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'unique:products,slug', 'max:255'],
            'ShortDescription' => ['nullable', 'string'],
            'Description' => ['nullable', 'string'],
            'Shipping_returns' => ['nullable', 'string'],
            'relatedProducts' => ['nullable', 'string'],
            'images' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'categories_id' => ['required', 'exists:categories,id'],
            'Subcategories_id' => ['nullable', 'exists:subcategories,id'],
            'brands_id' => ['nullable', 'exists:brands,id'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'barcode' => ['nullable', 'string'],
            'track_qty' => ['required', 'in:Yes,No'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'pstatus' => ['required', 'in:Yes,No'],
            'ProductFeature' => ['required', 'in:Yes,No'],
        ];
        
        return $rules;
    }
}
