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
        Schema::create('school_day_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('schedule_pattern_id')->constrained('schedule_patterns')->onDelete('cascade');
            $table->foreignUuid('school_institution_id')->constrained('school_institutions')->onDelete('cascade');
            $table->foreignUuid('school_level_id')->constrained('school_levels')->onDelete('cascade');
            $table->integer('day_of_week'); // 0 = Monday, 1 = Tuesday, ..., 5 = Saturday, 6 = Sunday
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_holiday')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['schedule_pattern_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_day_schedules');
    }
};
