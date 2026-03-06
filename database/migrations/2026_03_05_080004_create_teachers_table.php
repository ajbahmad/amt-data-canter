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
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('person_id')
                  ->constrained('persons')
                  ->onDelete('cascade');
            $table->foreignUuid('school_institution_id')
                  ->constrained('school_institutions')
                  ->onDelete('cascade');
            $table->string('teacher_id')->unique(); // Teacher ID/NIP
            $table->string('certification_number')->nullable(); // Certification number
            $table->date('hire_date')->nullable();
            $table->enum('employment_type', ['permanent', 'contract', 'honorary'])->default('contract');
            $table->enum('status', ['active', 'retired', 'resigned', 'on_leave'])->default('active');
            $table->text('specialization')->nullable();
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
        Schema::dropIfExists('teachers');
    }
};
