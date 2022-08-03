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
            'arrival_date' => ['required','date','date_format:"Y-m-d"'],
            'night_count' => ['required','integer','max:30'],
            'adult_count' => ['required','integer','max:5'],
            'child_count' => ['required','integer','max:5'],
            'room_type' => ['required']
        ];
    }
}
