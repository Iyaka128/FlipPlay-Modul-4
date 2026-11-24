<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique('media', 'title')],
            'type' => ['required', Rule::in(['Anime', 'Drama', 'Manga', 'Light Novel'])],
            'genre' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'cover_url' => ['nullable', 'url', 'max:2048'],
            'release_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
        ];
    }
}
