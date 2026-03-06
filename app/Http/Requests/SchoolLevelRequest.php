<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolLevelRequest extends FormRequest
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
        $id = $this->route('school_level') ? $this->route('school_level')->id : null;

        if ($this->isMethod('post')) {
            $roles['code'] = 'required|string|max:20|unique:school_levels,code';
        } else {
            $roles['code'] = 'required|string|max:20|unique:school_levels,code,' . $id;
        }

        $roles['school_institution_id'] = 'required|uuid|exists:school_institutions,id';
        $roles['name'] = 'required|string|max:50';
        $roles['description'] = 'nullable|string';
        $roles['is_active'] = 'nullable|boolean';

        return $roles;
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode level harus diisi',
            'code.unique' => 'Kode level sudah terdaftar',
            'name.required' => 'Nama level harus diisi',
        ];
    }
}
