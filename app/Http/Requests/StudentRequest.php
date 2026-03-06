<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $studentId = $this->student ? $this->student->id : null;
        
        return [
            'person_id' => 'required|uuid|exists:persons,id',
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'student_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students')->ignore($studentId),
            ],
            'enrollment_number' => 'nullable|string|max:50',
            'enrollment_date' => 'nullable|date',
            'status' => 'required|in:active,graduated,dropped_out,suspended',
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
            'student_id.required' => 'Nomor induk siswa wajib diisi.',
            'student_id.unique' => 'Nomor induk siswa sudah terdaftar.',
            'status.required' => 'Status siswa wajib dipilih.',
            'status.in' => 'Status siswa tidak valid.',
        ];
    }
}
