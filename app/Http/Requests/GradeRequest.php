<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradeRequest extends FormRequest
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
        $gradeId = $this->route('grade')?->id;

        return [
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'school_level_id' => 'required|uuid|exists:school_levels,id',
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('grades')->where('school_level_id', $this->input('school_level_id'))->ignore($gradeId),
            ],
            'order_no' => 'nullable|integer|min:0',
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
            'name.required' => 'Nama kelas harus diisi',
            'name.unique' => 'Nama kelas ini sudah ada untuk jenjang tersebut',
            'order_no.integer' => 'Nomor urutan harus angka',
        ];
    }
}
