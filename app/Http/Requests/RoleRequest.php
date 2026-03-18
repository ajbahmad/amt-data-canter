<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('role') ? $this->route('role')->id : null;

        $rules = [
            'application_id' => 'required|uuid|exists:applications,id',
            'name' => 'required|string|max:100',
            'slug' => $this->isMethod('post')
                ? 'required|string|max:100|unique:roles,slug'
                : 'required|string|max:100|unique:roles,slug,' . $id,
            'description' => 'nullable|string',
            'scope' => 'required|in:global,institution,school',
            'school_institution_id' => 'nullable|uuid|exists:school_institutions,id',
            'school_level_id' => 'nullable|uuid|exists:school_levels,id',
            'priority' => 'nullable|integer|min:0',
            'is_system' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'application_id.required' => 'Aplikasi harus dipilih',
            'application_id.exists' => 'Aplikasi tidak ditemukan',
            'name.required' => 'Nama role harus diisi',
            'slug.required' => 'Slug role harus diisi',
            'slug.unique' => 'Slug role sudah terdaftar',
            'scope.required' => 'Scope role harus dipilih',
            'school_institution_id.exists' => 'Institusi tidak ditemukan',
            'school_level_id.exists' => 'Tingkat sekolah tidak ditemukan',
        ];
    }
}
