<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'surname' => ['required','string'],
            'mail' => ['required','email'],
            'login' => ['required','string'],
            'password' => ['required','string'],
        ];
    }
}
