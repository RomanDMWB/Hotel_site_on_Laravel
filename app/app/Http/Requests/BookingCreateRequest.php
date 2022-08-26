<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => ['required','date','date_format:"Y-m-d"'],
            'nights' => ['required','integer','max:30'],
            'adults' => ['required','integer','max:5'],
            'childs' => ['required','integer','max:5'],
            'type' => ['required','string'],
            'place' => ['nullable','integer'],
            'cost' => ['nullable','integer']
        ];
    }
}
