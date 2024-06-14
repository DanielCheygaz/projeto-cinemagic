<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TheaterFormRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'photo_filename' => 'sometimes|string|max:255',
            'deleted_at' => 'sometimes|timestamp',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ];
    }
}
