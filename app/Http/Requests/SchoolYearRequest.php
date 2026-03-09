<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolYearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $schoolYear = $this->route('school_year');
        $schoolYearId = $schoolYear ? $schoolYear->id : null;

        return [
            'school_institution_id' => [
                'required',
                'uuid',
                Rule::exists('school_institutions', 'id'),
            ],
            'school_level_id' => [
                'required',
                'uuid',
                Rule::exists('school_levels', 'id'),
            ],
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('school_years')
                    ->where('school_institution_id', $this->input('school_institution_id'))
                    ->where('school_level_id', $this->input('school_level_id'))
                    ->ignore($schoolYearId),
            ],
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'school_institution_id.required' => 'Sekolah harus dipilih',
            'school_institution_id.uuid' => 'Format ID sekolah tidak valid',
            'school_institution_id.exists' => 'Sekolah yang dipilih tidak ditemukan',
            'school_level_id.required' => 'Jenjang sekolah harus dipilih',
            'school_level_id.uuid' => 'Format ID jenjang tidak valid',
            'school_level_id.exists' => 'Jenjang sekolah yang dipilih tidak ditemukan',
            'name.required' => 'Tahun akademik harus diisi',
            'name.max' => 'Tahun akademik maksimal 50 karakter',
            'name.unique' => 'Tahun akademik sudah terdaftar untuk sekolah ini',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Format tanggal mulai tidak valid',
            'start_date.before' => 'Tanggal mulai harus sebelum tanggal akhir',
            'end_date.required' => 'Tanggal akhir harus diisi',
            'end_date.date' => 'Format tanggal akhir tidak valid',
            'end_date.after' => 'Tanggal akhir harus setelah tanggal mulai',
        ];
    }
}
