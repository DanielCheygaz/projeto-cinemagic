<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'genre_code' => 'required|string|max:20',
            'year' => 'required|int',
            'poster_filename' => 'sometimes|string|max:255',
            'synopsis' => 'required|string',
            'trailer_url' => 'string|max:255',
        ];
    }
}
