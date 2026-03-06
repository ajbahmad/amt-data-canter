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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('person_id')
                  ->constrained('persons')
                  ->onDelete('cascade');
            $table->foreignUuid('school_institution_id')
                  ->constrained('school_institutions')
                  ->onDelete('cascade');
            $table->string('student_id')->unique(); // Student ID/NIS
            $table->string('enrollment_number')->nullable(); // Registration number
            $table->date('enrollment_date')->nullable();
            $table->enum('status', ['active', 'graduated', 'dropped_out', 'suspended'])->default('active');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
