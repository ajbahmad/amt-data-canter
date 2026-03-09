<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomHomeroomTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_room_id' => 'required|uuid|exists:class_rooms,id',
            'teacher_id' => 'required|uuid|exists:teachers,id',
            'assigned_at' => 'nullable',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'class_room_id.required' => 'Kelas harus dipilih.',
            'class_room_id.exists' => 'Kelas tidak ditemukan.',
            'teacher_id.required' => 'Guru harus dipilih.',
            'teacher_id.exists' => 'Guru tidak ditemukan.',
            'assigned_at.date_format' => 'Format tanggal penugasan tidak valid.',
        ];
    }
}
