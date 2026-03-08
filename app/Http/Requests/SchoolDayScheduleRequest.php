<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolDayScheduleRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'start_time' => 'nullable',
            'end_time' => 'nullable|after:start_time',
            'is_holiday' => 'boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'start_time.date_format' => 'Format jam mulai tidak valid',
            'end_time.date_format' => 'Format jam selesai tidak valid',
            'end_time.after' => 'Jam selesai harus lebih besar dari jam mulai',
            'is_holiday.boolean' => 'Status hari libur harus true atau false',
        ];
    }
}
