<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('application') ? $this->route('application')->id : null;

        $rules = [
            'name' => $this->isMethod('post') 
                ? 'required|string|max:255|unique:applications,name' 
                : 'required|string|max:255|unique:applications,name,' . $id,
            'slug' => $this->isMethod('post')
                ? 'required|string|max:100|unique:applications,slug'
                : 'required|string|max:100|unique:applications,slug,' . $id,
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string|max:255',
            'website_url' => 'nullable|string|max:255',
            'api_base_url' => 'nullable|string|max:255',
            'api_client_id' => 'nullable|string|max:100|unique:applications,api_client_id,' . $id,
            'is_active' => 'nullable|boolean',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama aplikasi harus diisi',
            'name.unique' => 'Nama aplikasi sudah terdaftar',
            'slug.required' => 'Slug aplikasi harus diisi',
            'slug.unique' => 'Slug aplikasi sudah terdaftar',
        ];
    }
}
