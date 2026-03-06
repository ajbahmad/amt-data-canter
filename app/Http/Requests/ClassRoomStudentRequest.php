<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_room_id' => 'required|uuid|exists:class_rooms,id',
            'student_id' => 'required|uuid|exists:students,id',
            'joined_at' => 'nullable|date_format:Y-m-d H:i:s',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'class_room_id.required' => 'Kelas harus dipilih.',
            'class_room_id.exists' => 'Kelas tidak ditemukan.',
            'student_id.required' => 'Siswa harus dipilih.',
            'student_id.exists' => 'Siswa tidak ditemukan.',
            'joined_at.date_format' => 'Format tanggal bergabung tidak valid.',
        ];
    }
}
