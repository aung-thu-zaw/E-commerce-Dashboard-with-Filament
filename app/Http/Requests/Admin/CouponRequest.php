<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
            'code' => ['required', 'max:100'],
            'description' => ['required', 'string','max:255'],
            'type' => ['required', 'string', Rule::in(['percentage','fixed','free_item'])],
            'discount_amount' => ['nullable', 'numeric'],
            'minimum_order_amount' => ['nullable', 'numeric'],
            'usage_limit' => ['nullable', 'numeric'],
            'free_item_id' => ['nullable', 'numeric',Rule::exists("products", "id")],
            'validity_period' => ['required', 'string', Rule::in(['once', 'multiple', 'forever'])],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
        ];
    }
}
