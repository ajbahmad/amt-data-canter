<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherSubjectAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teacher_id' => 'required|uuid|exists:teachers,id',
            'subject_id' => 'required|uuid|exists:subjects,id',
            'class_room_id' => 'required|uuid|exists:class_rooms,id',
            'semester_id' => 'required|uuid|exists:semesters,id',
            'assigned_at' => 'nullable',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'teacher_id.required' => 'Guru harus dipilih.',
            'teacher_id.exists' => 'Guru tidak ditemukan.',
            'subject_id.required' => 'Mata pelajaran harus dipilih.',
            'subject_id.exists' => 'Mata pelajaran tidak ditemukan.',
            'class_room_id.required' => 'Kelas harus dipilih.',
            'class_room_id.exists' => 'Kelas tidak ditemukan.',
            'semester_id.required' => 'Semester harus dipilih.',
            'semester_id.exists' => 'Semester tidak ditemukan.',
            'assigned_at.date_format' => 'Format tanggal penugasan tidak valid.',
        ];
    }
}
