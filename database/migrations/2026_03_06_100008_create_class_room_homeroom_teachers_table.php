<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_room_homeroom_teachers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();
            $table->foreignUuid('school_level_id')->constrained('school_levels')->cascadeOnDelete();
            $table->foreignUuid('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignUuid('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->dateTime('assigned_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['class_room_id', 'teacher_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_room_homeroom_teachers');
    }
};
