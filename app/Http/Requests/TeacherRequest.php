<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
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
        $teacherId = $this->teacher ? $this->teacher->id : null;
        
        return [
            'person_id' => 'required|uuid|exists:persons,id',
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'teacher_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('teachers')->ignore($teacherId),
            ],
            'certification_number' => 'nullable|string|max:50',
            'hire_date' => 'nullable|date',
            'employment_type' => 'required|in:permanent,contract,honorary',
            'status' => 'required|in:active,retired,resigned,on_leave',
            'specialization' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'person_id.required' => 'Orang wajib dipilih.',
            'person_id.exists' => 'Orang tidak valid.',
            'school_institution_id.required' => 'Sekolah wajib dipilih.',
            'school_institution_id.exists' => 'Sekolah tidak valid.',
            'teacher_id.required' => 'Nomor induk guru wajib diisi.',
            'teacher_id.unique' => 'Nomor induk guru sudah terdaftar.',
            'employment_type.required' => 'Tipe kepegawaian wajib dipilih.',
            'employment_type.in' => 'Tipe kepegawaian tidak valid.',
            'status.required' => 'Status guru wajib dipilih.',
            'status.in' => 'Status guru tidak valid.',
        ];
    }
}
