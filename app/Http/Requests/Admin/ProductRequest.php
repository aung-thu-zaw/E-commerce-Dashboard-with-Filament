<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'category_id' => ['required', 'numeric', Rule::exists('categories', 'id')],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:1500'],
            'additional_images.*' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:1500'],
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')],
            'ingredients' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'qty' => ['required', 'numeric'],
            'is_available' => ['required', Rule::in(['true', 'false', true, false, 0, 1])],
            'base_price' => ['required'],
            'discount_price' => ['nullable'],
            'discount_end_time' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'addons' => ['nullable'],
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $product = $route->parameter('product');
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($product)];

            if ($this->additional_images) {

                $rules['additional_images.*'] = ['required', 'image', 'mimes:png,jpg,jpeg', 'max:1500'];
            } else {

                $rules['additional_images.*'] = ['nullable'];
            }

            if ($this->hasFile('image')) {

                $rules['image'] = ['required', 'image', 'mimes:png,jpg,jpeg', 'max:1500'];
            } else {

                $rules['image'] = ['nullable'];
            }
        }

        return $rules;
    }
}
