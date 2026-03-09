<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'type' => 'required|in:holiday,event,note',
            'is_holiday' => 'boolean',
            'color' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
            'school_institution_ids' => 'nullable|array',
            'school_institution_ids.*' => 'uuid|exists:school_institutions,id',
            'school_level_ids' => 'nullable|array',
            'school_level_ids.*' => 'uuid|exists:school_levels,id',
            'class_room_ids' => 'nullable|array',
            'class_room_ids.*' => 'uuid|exists:class_rooms,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul event harus diisi',
            'title.max' => 'Judul event tidak boleh lebih dari 255 karakter',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Format tanggal mulai tidak valid',
            'end_date.date' => 'Format tanggal akhir tidak valid',
            'end_date.after_or_equal' => 'Tanggal akhir harus lebih besar atau sama dengan tanggal mulai',
            'type.required' => 'Tipe event harus diisi',
            'type.in' => 'Tipe event harus salah satu dari: event, holiday, note',
            'color.regex' => 'Format warna tidak valid. Gunakan format hex (#RRGGBB)',
            'school_institution_ids.*.uuid' => 'ID institusi tidak valid',
            'school_institution_ids.*.exists' => 'Institusi yang dipilih tidak ditemukan',
            'school_level_ids.*.uuid' => 'ID level sekolah tidak valid',
            'school_level_ids.*.exists' => 'Level sekolah yang dipilih tidak ditemukan',
            'class_room_ids.*.uuid' => 'ID kelas tidak valid',
            'class_room_ids.*.exists' => 'Kelas yang dipilih tidak ditemukan',
        ];
    }
}
