<?php

namespace App\Http\Requests\Admin\ManageShipping;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingMethodRequest extends FormRequest
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
            "name" => ["required","string","max:255",Rule::unique("shipping_methods", "name")],
            "cost" => ["required","numeric"]
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $shippingMethod = $route->parameter('shipping_method');
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('shipping_methods', 'name')->ignore($shippingMethod)];
        }

        return $rules;
    }
}
