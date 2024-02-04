<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartItemRequest extends FormRequest
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
        return [
            'product_id' => ['required', 'numeric', Rule::exists('products', 'id')],
            'qty' => ['required', 'numeric'],
            'unit_price' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
            'attributes' => ['nullable'],
        ];
    }
}
