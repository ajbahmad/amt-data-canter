<?php

namespace App\Http\Requests;

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
        $id = $this->route('school_institution') ? $this->route('school_institution')->id : null;

        if ($this->isMethod('post')) {
            $roles['code'] = 'required|string|max:50|unique:school_institutions,code';
        } else {
            $roles['code']          = 'required|string|max:50|unique:school_institutions,code,' . $id;
        }
        $roles['name']          = 'required|string|max:255';
        $roles['npsn']          = 'nullable|string|max:20';
        $roles['address']       = 'nullable|string';
        $roles['phone']         = 'nullable|string|max:30';
        $roles['email']         = 'nullable|email|max:255';
        $roles['is_active']     = 'nullable|boolean';

        return $roles;
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode sekolah harus diisi',
            'code.unique' => 'Kode sekolah sudah terdaftar',
            'name.required' => 'Nama sekolah harus diisi',
        ];
    }
}
