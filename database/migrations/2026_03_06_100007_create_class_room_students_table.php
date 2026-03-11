<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_room_students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('school_institution_id')->nullable()->foreign('school_institution_id')
                  ->references('id')
                  ->on('school_institutions')
                  ->onDelete('set null');
            $table->uuid('school_level_id')->nullable()->foreign('school_level_id')
                  ->references('id')
                  ->on('school_levels')
                  ->onDelete('set null');
            $table->foreignUuid('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignUuid('student_id')->constrained('students')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->dateTime('joined_at')->nullable();
            $table->timestamps();

            $table->unique(['class_room_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_room_students');
    }
};
