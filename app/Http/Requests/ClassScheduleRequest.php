<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassScheduleRequest extends FormRequest
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
        return [
            'school_institution_id' => 'required|uuid|exists:school_institutions,id',
            'school_level_id' => 'required|uuid|exists:school_levels,id',
            'class_room_id' => 'required|uuid|exists:class_rooms,id',
            'teacher_id' => 'required|uuid|exists:teachers,id',
            'subject_id' => 'required|uuid|exists:subjects,id',
            'semester_id' => 'required|uuid|exists:semesters,id',
            'day_of_week' => 'required|integer|between:1,7',
            'start_time_slot_id' => 'required|uuid|exists:time_slots,id',
            'end_time_slot_id' => 'required|uuid|exists:time_slots,id',
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'school_institution_id.required' => 'Sekolah harus dipilih',
            'school_institution_id.exists' => 'Sekolah tidak valid',
            'school_level_id.required' => 'Tingkat sekolah harus dipilih',
            'school_level_id.exists' => 'Tingkat sekolah tidak valid',
            'class_room_id.required' => 'Kelas harus dipilih',
            'class_room_id.exists' => 'Kelas tidak valid',
            'teacher_id.required' => 'Guru harus dipilih',
            'teacher_id.exists' => 'Guru tidak valid',
            'subject_id.required' => 'Mapel harus dipilih',
            'subject_id.exists' => 'Mapel tidak valid',
            'start_time_slot_id.required' => 'Jam mulai harus dipilih',
            'start_time_slot_id.exists' => 'Jam mulai tidak valid',
            'end_time_slot_id.required' => 'Jam selesai harus dipilih',
            'end_time_slot_id.exists' => 'Jam selesai tidak valid',
            'semester_id.required' => 'Semester harus dipilih',
            'semester_id.exists' => 'Semester tidak valid',
            'day_of_week.required' => 'Hari harus dipilih',
            'day_of_week.between' => 'Hari harus antara 1-7',
        ];
    }
}
