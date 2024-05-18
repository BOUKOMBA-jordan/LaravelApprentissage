<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormPostRequest extends FormRequest
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
            'title' => ['required', 'min:8'],
            'slug' => ['required', 'min:8', 'regex:/^[0-9a-z\-]+$/', Rule::unique('posts')->ignore($this->route()->parameter('post'))],
            'content' => ['required'],
            'category_id' =>['required', 'exists:categories,id'],
            'tags' => ['array', 'exists:tags,id', 'required'],
            'image' => ['image', 'max:2000']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->input('slug') ?: Str::slug($this->input('title')),
        ]);
    }
}
