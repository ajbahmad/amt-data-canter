<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SemesterRequest extends FormRequest
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
        $semesterId = $this->route('semester')?->id;

        return [
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'school_year_id' => 'required|uuid|exists:school_years,id',
            'name' => [
                'required',
                'string',
                'max:20',
                Rule::unique('semesters')->where('school_year_id', $this->input('school_year_id'))->ignore($semesterId),
            ],
            'semester' => 'nullable|integer|min:1|max:2',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'school_institution_id.required' => 'Sekolah harus dipilih',
            'school_institution_id.exists' => 'Sekolah tidak ditemukan',
            'school_year_id.required' => 'Tahun akademik harus dipilih',
            'school_year_id.exists' => 'Tahun akademik tidak ditemukan',
            'name.required' => 'Nama semester harus diisi',
            'name.unique' => 'Semester dengan nama ini sudah ada untuk tahun akademik tersebut',
            'start_date.date' => 'Tanggal mulai harus format tanggal',
            'end_date.date' => 'Tanggal akhir harus format tanggal',
            'end_date.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal mulai',
        ];
    }
}
