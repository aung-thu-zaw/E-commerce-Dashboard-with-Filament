<?php

namespace App\Http\Requests\Admin\ManageShipping;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryAreaRequest extends FormRequest
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
            "name" => ["required","string","max:255",Rule::unique("delivery_areas", "name")]
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $deliveryArea = $route->parameter('delivery_area');
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('delivery_areas', 'name')->ignore($deliveryArea)];
        }

        return $rules;
    }
}
