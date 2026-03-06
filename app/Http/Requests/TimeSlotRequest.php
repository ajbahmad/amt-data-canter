<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeSlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'school_level_id' => 'required|uuid|exists:school_levels,id',
            'name' => 'required|string|max:50',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'order_no' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'school_institution_id.required' => 'Sekolah harus dipilih.',
            'school_institution_id.exists' => 'Sekolah tidak ditemukan.',
            'school_level_id.required' => 'Tingkat sekolah harus dipilih.',
            'school_level_id.exists' => 'Tingkat sekolah tidak ditemukan.',
            'name.required' => 'Nama jam pelajaran harus diisi.',
            'start_time.required' => 'Jam mulai harus diisi.',
            'start_time.date_format' => 'Format jam mulai harus HH:MM.',
            'end_time.required' => 'Jam berakhir harus diisi.',
            'end_time.date_format' => 'Format jam berakhir harus HH:MM.',
            'end_time.after' => 'Jam berakhir harus lebih besar dari jam mulai.',
        ];
    }
}
