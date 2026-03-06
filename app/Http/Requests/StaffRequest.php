<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffRequest extends FormRequest
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
        $staffId = $this->staff ? $this->staff->id : null;
        
        return [
            'person_id' => 'required|uuid|exists:persons,id',
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'staff_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('staffs')->ignore($staffId),
            ],
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'employment_type' => 'required|in:permanent,contract,honorary',
            'status' => 'required|in:active,retired,resigned,on_leave',
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
            'staff_id.required' => 'Nomor induk staf wajib diisi.',
            'staff_id.unique' => 'Nomor induk staf sudah terdaftar.',
            'position.required' => 'Posisi wajib diisi.',
            'employment_type.required' => 'Tipe kepegawaian wajib dipilih.',
            'employment_type.in' => 'Tipe kepegawaian tidak valid.',
            'status.required' => 'Status staf wajib dipilih.',
            'status.in' => 'Status staf tidak valid.',
        ];
    }
}
