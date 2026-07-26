<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePost extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::check('create', Post::class);
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:255',
                'regex:/^[\d\w][\d\w_-]+$/',
                Rule::unique('posts', 'slug')->ignore($this->post->id ?? 0),
            ],
            'content' => ['required', 'string', 'min:100'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:50'],
            'hidden' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Заголовок',
            'slug' => 'SEO slug',
            'content' => 'Контент',
            'tags' => 'Теги',
            'tags.*' => 'Тег',
        ];
    }
}
