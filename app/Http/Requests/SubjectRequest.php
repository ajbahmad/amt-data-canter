<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
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
        $subjectId = $this->route('subject')?->id;

        return [
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'school_level_id' => 'required|uuid|exists:school_levels,id',
            'code' => 'nullable|string|max:50',
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('subjects')->where('school_level_id', $this->input('school_level_id'))->ignore($subjectId),
            ],
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'school_institution_id.required' => 'Sekolah harus dipilih',
            'school_institution_id.exists' => 'Sekolah tidak ditemukan',
            'school_level_id.required' => 'Jenjang sekolah harus dipilih',
            'school_level_id.exists' => 'Jenjang sekolah tidak ditemukan',
            'name.required' => 'Nama mata pelajaran harus diisi',
            'name.unique' => 'Mata pelajaran dengan nama ini sudah ada untuk jenjang tersebut',
            'code.max' => 'Kode mata pelajaran maksimal 50 karakter',
        ];
    }
}