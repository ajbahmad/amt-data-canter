<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();
            $table->foreignUuid('school_level_id')->constrained('school_levels')->cascadeOnDelete();
            $table->string('code', 50)->nullable();
            $table->string('name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['school_level_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
