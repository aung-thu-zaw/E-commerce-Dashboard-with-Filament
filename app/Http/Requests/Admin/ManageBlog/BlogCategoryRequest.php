<?php

namespace App\Http\Requests\Admin\ManageBlog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('blog_categories', 'name')],
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $blogCategory = $route->parameter('blog_category');
            $rules['name'] = ['required', 'string', 'max:255', Rule::unique('blog_categories', 'name')->ignore($blogCategory)];
        }

        return $rules;
    }
}
