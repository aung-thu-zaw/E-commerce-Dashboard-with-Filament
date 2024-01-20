<?php

namespace App\Http\Requests\Admin\AuthorityManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')],
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $role = $route->parameter('role');
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role)];
        }

        return $rules;
    }
}
