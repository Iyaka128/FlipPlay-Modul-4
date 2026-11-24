<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $media = $this->route('media');

        return [
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('media', 'title')->ignore($media),
            ],
            'type' => ['sometimes', 'required', Rule::in(['Anime', 'Drama', 'Manga', 'Light Novel'])],
            'genre' => ['sometimes', 'nullable', 'string', 'max:100'],
            'description' => ['sometimes', 'nullable', 'string'],
            'cover_url' => ['sometimes', 'nullable', 'url', 'max:2048'],
            'release_year' => ['sometimes', 'nullable', 'integer', 'min:1900', 'max:2100'],
        ];
    }
}
