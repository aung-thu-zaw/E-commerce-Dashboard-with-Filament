<?php

namespace App\Http\Requests\Admin\ManageBlog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogContentRequest extends FormRequest
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
            'blog_category_id' => ['required', 'numeric', Rule::exists('blog_categories', 'id')],
            'title' => ['required', 'string', 'max:255', Rule::unique('blog_contents', 'title')],
            'status' => ['required', 'string', Rule::in(['draft', 'published', 'hidden'])],
            'thumbnail' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:1500'],
            'content' => ['required', 'string'],
            'tags' => ['nullable', 'array'],
        ];

        $route = $this->route();

        if ($route && in_array($this->method(), ['PUT', 'PATCH'])) {
            $blogContent = $route->parameter('blog_content');
            $rules['title'] = ['required', 'string', 'max:255', Rule::unique('blog_contents', 'title')->ignore($blogContent)];

            if ($this->hasFile('thumbnail')) {

                $rules['thumbnail'] = ['required', 'image', 'mimes:png,jpg,jpeg', 'max:1500'];
            } else {

                $rules['thumbnail'] = ['nullable'];
            }
        }

        return $rules;
    }
}
