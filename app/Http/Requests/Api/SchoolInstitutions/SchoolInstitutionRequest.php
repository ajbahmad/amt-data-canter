<?php

namespace App\Http\Requests\Api\SchoolInstitutions;

use Illuminate\Foundation\Http\FormRequest;

class SchoolInstitutionRequest extends FormRequest
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
        $schoolInstitution = $this->route('school_institution');
        $schoolInstitutionId = $schoolInstitution ? $schoolInstitution->id : null;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:school_institutions,code' . ($schoolInstitutionId ? ",{$schoolInstitutionId}" : ''),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:school_institutions,email' . ($schoolInstitutionId ? ",{$schoolInstitutionId}" : ''),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            'city' => [
                'nullable',
                'string',
                'max:100',
            ],
            'province' => [
                'nullable',
                'string',
                'max:100',
            ],
            'postal_code' => [
                'nullable',
                'string',
                'max:20',
            ],
            'country' => [
                'nullable',
                'string',
                'max:100',
            ],
            'website' => [
                'nullable',
                'url',
                'max:255',
            ],
            'principal_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'principal_phone' => [
                'nullable',
                'string',
                'max:20',
            ],
            'principal_email' => [
                'nullable',
                'email',
                'max:255',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'School institution code is required.',
            'code.unique' => 'This school institution code already exists.',
            'name.required' => 'School institution name is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'website.url' => 'Please provide a valid website URL.',
            'principal_email.email' => 'Please provide a valid principal email address.',
        ];
    }
}
