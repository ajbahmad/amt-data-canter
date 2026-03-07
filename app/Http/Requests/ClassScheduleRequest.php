<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ClassSchedule;
use Illuminate\Validation\Validator;

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

    /**
     * Validasi custom menggunakan after hook
     * Mencegah jadwal bentrok di kelas dan guru yang sama
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $this->validateNoScheduleConflict($validator);
        });
    }

    /**
     * Validasi untuk mencegah bentrok jadwal
     * 
     * Cek 2 kondisi:
     * 1. Kelas tidak boleh memiliki 2 jadwal di hari & jam yang sama dalam semester yang sama
     * 2. Guru tidak boleh mengajar di 2 kelas berbeda di hari & jam yang sama dalam semester yang sama
     */
    private function validateNoScheduleConflict(Validator $validator)
    {
        $classRoomId = $this->input('class_room_id');
        $teacherId = $this->input('teacher_id');
        $dayOfWeek = $this->input('day_of_week');
        $startTimeSlotId = $this->input('start_time_slot_id');
        $endTimeSlotId = $this->input('end_time_slot_id');
        $semesterId = $this->input('semester_id');
        $scheduleId = $this->route('id'); // ID untuk update (null untuk create)

        if (!$classRoomId || !$teacherId || !$dayOfWeek || !$startTimeSlotId || !$endTimeSlotId || !$semesterId) {
            return; // Skip jika data belum lengkap
        }

        // Ambil urutan time slot untuk perbandingan yang akurat
        $newStartOrder = $this->getTimeSlotOrder($startTimeSlotId);
        $newEndOrder = $this->getTimeSlotOrder($endTimeSlotId);

        if ($newStartOrder === null || $newEndOrder === null) {
            return; // Time slot tidak valid
        }

        /**
         * KONDISI 1: Cek bentrok jadwal di KELAS
         * 
         * Kelas tidak boleh punya jadwal bentrok pada:
         * - Hari yang sama (day_of_week)
         * - Jam yang sama atau tumpang tindih (time slot)
         * - Semester yang sama
         */
        $classConflict = ClassSchedule::where('class_room_id', $classRoomId)
            ->where('day_of_week', $dayOfWeek)
            ->where('semester_id', $semesterId)
            ->when($scheduleId, function ($q) use ($scheduleId) {
                return $q->where('id', '!=', $scheduleId);
            })
            ->with('startTimeSlot', 'endTimeSlot')
            ->get();

        foreach ($classConflict as $schedule) {
            $existStartOrder = $this->getTimeSlotOrder($schedule->start_time_slot_id);
            $existEndOrder = $this->getTimeSlotOrder($schedule->end_time_slot_id);

            // Cek tumpang tindih: newStart <= existEnd AND newEnd >= existStart
            if ($newStartOrder <= $existEndOrder && $newEndOrder >= $existStartOrder) {
                $validator->errors()->add(
                    'start_time_slot_id',
                    "Kelas sudah memiliki jadwal pada jam ke-{$existStartOrder} sampai jam ke-{$existEndOrder} di hari dan semester yang sama."
                );
                break;
            }
        }

        /**
         * KONDISI 2: Cek bentrok jadwal di GURU
         * 
         * Guru tidak boleh mengajar di JAM YANG SAMA pada:
         * - Hari yang sama (day_of_week)
         * - Jam yang sama atau tumpang tindih (time slot)
         * - Semester yang sama
         * - Kelas APAPUN (termasuk kelas yang sama)
         */
        $teacherConflict = ClassSchedule::where('teacher_id', $teacherId)
            ->where('day_of_week', $dayOfWeek)
            ->where('semester_id', $semesterId)
            ->when($scheduleId, function ($q) use ($scheduleId) {
                return $q->where('id', '!=', $scheduleId);
            })
            ->with('classRoom', 'startTimeSlot', 'endTimeSlot')
            ->get();

        foreach ($teacherConflict as $schedule) {
            $existStartOrder = $this->getTimeSlotOrder($schedule->start_time_slot_id);
            $existEndOrder = $this->getTimeSlotOrder($schedule->end_time_slot_id);

            // Cek tumpang tindih: newStart <= existEnd AND newEnd >= existStart
            if ($newStartOrder <= $existEndOrder && $newEndOrder >= $existStartOrder) {
                $validator->errors()->add(
                    'teacher_id',
                    "Guru sudah memiliki jadwal mengajar di kelas {$schedule->classRoom->name} dari jam ke-{$existStartOrder} sampai jam ke-{$existEndOrder} pada hari dan semester yang sama."
                );
                break;
            }
        }
    }

    /**
     * Helper untuk mendapatkan urutan time slot
     * Asumsi: time_slots memiliki kolom 'order' atau diurutkan berdasarkan waktu
     * Jika tidak ada, gunakan ID sebagai urutan fallback
     */
    private function getTimeSlotOrder($timeSlotId)
    {
        static $timeSlotOrders = [];

        // Cache hasil untuk menghindari query berulang
        if (isset($timeSlotOrders[$timeSlotId])) {
            return $timeSlotOrders[$timeSlotId];
        }

        $timeSlot = \App\Models\TimeSlot::find($timeSlotId);
        
        if (!$timeSlot) {
            return null;
        }

        // Cari urutan berdasarkan waktu mulai, diurutkan dari paling awal
        $allTimeSlots = \App\Models\TimeSlot::orderBy('start_time')->get();
        
        $order = 1;
        foreach ($allTimeSlots as $index => $slot) {
            if ($slot->id === $timeSlotId) {
                $timeSlotOrders[$timeSlotId] = $order;
                return $order;
            }
            $order++;
        }

        return null;
    }
}
