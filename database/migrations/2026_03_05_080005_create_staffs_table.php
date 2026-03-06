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
        Schema::create('staffs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('person_id')
                  ->constrained('persons')
                  ->onDelete('cascade');
            $table->foreignUuid('school_institution_id')
                  ->constrained('school_institutions')
                  ->onDelete('cascade');
            $table->string('staff_id')->unique(); // Staff ID/NIP
            $table->string('position');
            $table->string('department')->nullable();
            $table->date('hire_date')->nullable();
            $table->enum('employment_type', ['permanent', 'contract', 'honorary'])->default('contract');
            $table->enum('status', ['active', 'retired', 'resigned', 'on_leave'])->default('active');
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
        Schema::dropIfExists('staffs');
    }
};
