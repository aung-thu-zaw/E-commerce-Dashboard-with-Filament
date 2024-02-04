<?php

namespace App\Http\Requests\Admin\AccountManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminManageRequest extends FormRequest
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
            'role_id' => ['required', 'numeric', Rule::exists('roles', 'id')],
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')],
            'email' => ['required', 'email', 'lowercase', 'max:255', Rule::unique('users', 'email')],
            'phone' => ['required', 'string', Rule::unique('users', 'phone')],
            'password' => ['required', 'confirmed', Password::default()],
            'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:1500'],
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $user = $this->route()->parameter('admin_account');
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($user)];
            $rules['email'] = ['required', 'email', 'lowercase', 'max:255', Rule::unique('users', 'email')->ignore($user)];
            $rules['phone'] = ['required', 'string', Rule::unique('users', 'phone')->ignore($user)];
            $rules['password'] = ['nullable'];

            if ($this->hasFile('avatar')) {
                $rules['avatar'] = ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:1500'];
            } else {
                $rules['avatar'] = ['nullable', 'string'];
            }
        }

        return $rules;
    }
}
