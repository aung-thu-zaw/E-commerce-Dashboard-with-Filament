<?php

namespace App\Http\Requests\Admin\ManageReservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TableRequest extends FormRequest
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
            "name" => ["required","string","max:255",Rule::unique("tables", "name")],
            "capacity" => ["required","numeric"],
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $table = $route->parameter('table');
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('tables', 'name')->ignore($table)];
        }

        return $rules;
    }
}
