<?php

namespace App\Http\Requests\Admin\EmployeeManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            "employee_position_id" => ["required","numeric",Rule::exists("employees", "id")],
            "image" => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:1500'],
            "name" => ["required","string","max:255"],
            'email' => ['required', 'email', 'lowercase', 'max:255', Rule::unique('users', 'email')],
            'phone' => ['required', 'string', Rule::unique('users', 'phone')],
            "address" => ["required","string"],
            "experience" => ["required","string"],
            "salary" => ["required","numeric"],
            "vacation" => ["nullable","string",Rule::in(["sunday","monday","tuesday","wednesday","thursday","friday","saturday"])],
            "status" => ["required",Rule::in(["active","inactive"])],
            "date_of_birth" => ["required","date"],
            "joining_date" => ["required","date"],
            "termination_date" => ["nullable","date"],
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $employee = $this->route()->parameter('employee');
            $rules['email'] = ['required', 'email', 'lowercase', 'max:255', Rule::unique('employees', 'email')->ignore($employee)];
            $rules['phone'] = ['required', 'string', Rule::unique('employees', 'phone')->ignore($employee)];

            if ($this->hasFile('image')) {
                $rules['image'] = ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:1500'];
            } else {
                $rules['image'] = ['nullable', 'string'];
            }
        }


        return $rules;
    }
}
