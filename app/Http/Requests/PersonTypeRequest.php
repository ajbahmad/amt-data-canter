<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonTypeRequest extends FormRequest
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
        $personTypeId = $this->route('person_type') ? $this->route('person_type')->id : null;
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('person_types', 'name')->ignore($personTypeId, 'id'),
            ],
            'description' => 'nullable|string|max:1000',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama tipe orang wajib diisi.',
            'name.unique' => 'Nama tipe orang sudah ada.',
            'name.max' => 'Nama tipe orang maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }
}
