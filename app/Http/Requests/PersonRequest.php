<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonRequest extends FormRequest
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
        $personId = $this->person ? $this->person->id : null;
        if ($this->photo_only) {
            return [
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ];
        }
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('persons')->ignore($personId),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('persons')->ignore($personId),
            ],
            'address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'birth_place' => 'nullable|string|max:255',
            'identity_number' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('persons')->ignore($personId),
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'school_institution_id' => 'nullable|uuid|exists:school_institutions,id',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'Nama depan wajib diisi.',
            'first_name.string' => 'Nama depan harus berupa teks.',
            'first_name.max' => 'Nama depan maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.unique' => 'Nomor telepon sudah terdaftar.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF.',
            'photo.max' => 'Ukuran gambar maksimal 5 MB.',
            'identity_number.unique' => 'Nomor identitas sudah terdaftar.',
            'school_institution_id.uuid' => 'ID institusi sekolah tidak valid.',
            'school_institution_id.exists' => 'Institusi sekolah yang dipilih tidak ditemukan.',
        ];
    }
}
