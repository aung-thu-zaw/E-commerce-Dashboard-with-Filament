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
            "code" => ["required","max:100"],
            "description" => ["required","string"],
            "type" => ["required","string",Rule::in(['percentage', 'fixed', 'buy_one_get_one', 'free_item', 'loyalty', 'special_event', 'online_ordering', 'birthday', 'referral', 'early_bird'])],
            "discount_amount" => ["nullable","numeric"],
            "minimum_order_amount" => ["nullable","numeric"],
            "free_item_quantity" => ['nullable','numeric'],
            "loyalty_stamps_required" => ['nullable','numeric'],
            "validity_period" => ["required","string",Rule::in(['once', 'multiple', 'forever'])],
            "start_date" => ["nullable","date"],
            "end_date" => ["nullable","date"],
            "status" => ["required","string",Rule::in(["active","inactive"])],
        ];
    }
}
