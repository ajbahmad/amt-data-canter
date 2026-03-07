<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();
            $table->foreignUuid('school_level_id')->constrained('school_levels')->cascadeOnDelete();
            $table->foreignUuid('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignUuid('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignUuid('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignUuid('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->foreignUuid('start_time_slot_id')->constrained('time_slots')->cascadeOnDelete();
            $table->foreignUuid('end_time_slot_id')->constrained('time_slots')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(
                ['class_room_id', 'semester_id', 'day_of_week', 'start_time_slot_id', 'end_time_slot_id'],
                'schedule_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
