<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user') ? $this->route('user')->id : null;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => $this->isMethod('post')
                ? 'required|email|max:255|unique:users,email'
                : 'required|email|max:255|unique:users,email,' . $id,
            'person_id' => 'nullable|uuid|exists:persons,id',
            'is_active' => 'nullable|boolean',
        ];

        // Password required only for create
        if ($this->isMethod('post')) {
            $rules['password'] = [
                'required',
                'min:8',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ];
        } else if ($this->filled('password')) {
            // Password optional for update, but if filled must be valid
            $rules['password'] = [
                'min:8',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama user harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password konfirmasi tidak sesuai',
        ];
    }
}
