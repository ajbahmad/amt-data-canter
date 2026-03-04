<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();
            $table->foreignUuid('school_year_id')->constrained('school_years')->cascadeOnDelete();
            $table->foreignUuid('grade_id')->constrained('grades')->cascadeOnDelete();
            $table->string('name', 50);
            $table->unsignedInteger('capacity')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['school_year_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_rooms');
    }
};
