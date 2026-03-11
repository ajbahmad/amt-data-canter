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
            'school_institution_id' => 'nullable|uuid|exists:school_institutions,id',
            'school_level_id' => 'nullable|uuid|exists:school_levels,id',
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
            'school_institution_id.uuid' => 'ID institusi sekolah tidak valid.',
            'school_institution_id.exists' => 'Institusi sekolah tidak ditemukan.',
            'school_level_id.uuid' => 'ID jenjang sekolah tidak valid.',
            'school_level_id.exists' => 'Jenjang sekolah tidak ditemukan.',
            'student_id.required' => 'Siswa harus dipilih.',
            'student_id.exists' => 'Siswa tidak ditemukan.',
            'joined_at.date_format' => 'Format tanggal bergabung tidak valid.',
        ];
    }
}
