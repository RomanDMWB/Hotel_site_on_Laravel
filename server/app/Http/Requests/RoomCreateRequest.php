<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','string'],
            'cost' => ['required','int'],
            'size' => ['required','string'],
            'description' => ['required','string'],
            'image' => ['required','string']
        ];
    }
}
