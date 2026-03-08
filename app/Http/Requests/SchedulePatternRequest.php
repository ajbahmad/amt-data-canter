<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchedulePatternRequest extends FormRequest
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
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'school_level_id' => 'required|uuid|exists:school_levels,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'school_institution_id.required' => 'Institusi sekolah harus dipilih',
            'school_institution_id.uuid' => 'Format institusi sekolah tidak valid',
            'school_institution_id.exists' => 'Institusi sekolah tidak ditemukan',
            'school_level_id.required' => 'Level sekolah harus dipilih',
            'school_level_id.uuid' => 'Format level sekolah tidak valid',
            'school_level_id.exists' => 'Level sekolah tidak ditemukan',
            'name.required' => 'Nama pola jadwal harus diisi',
            'name.max' => 'Nama pola jadwal maksimal 255 karakter',
        ];
    }
}
