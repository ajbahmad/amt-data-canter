<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassRoomRequest extends FormRequest
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
        $classRoomId = $this->route('class_room')?->id;

        return [
            'school_institution_id' => 'required|exists:school_institutions,id',
            'school_year_id' => 'required|uuid|exists:school_years,id',
            'grade_id' => 'required|uuid|exists:grades,id',
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('class_rooms')->where('school_year_id', $this->input('school_year_id'))->ignore($classRoomId),
            ],
            'capacity' => 'nullable|integer|min:0',
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
            'grade_id.required' => 'Kelas harus dipilih',
            'grade_id.exists' => 'Kelas tidak ditemukan',
            'name.required' => 'Nama rombel harus diisi',
            'name.unique' => 'Nama rombel ini sudah ada untuk tahun akademik tersebut',
            'capacity.integer' => 'Kapasitas harus angka',
        ];
    }
}
