<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('application_id');
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->text('description')->nullable();
            
            // Scope: 'global', 'institution', 'school'
            $table->enum('scope', ['global', 'institution', 'school'])->default('global');
            
            // Nullable - only set based on scope
            $table->uuid('school_institution_id')->nullable();
            $table->uuid('school_level_id')->nullable();
            
            $table->integer('priority')->default(0);
            $table->boolean('is_system')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
                ->onDelete('cascade');

            $table->foreign('school_institution_id')
                ->references('id')
                ->on('school_institutions')
                ->onDelete('set null');

            $table->foreign('school_level_id')
                ->references('id')
                ->on('school_levels')
                ->onDelete('set null');

            $table->unique(['application_id', 'slug']);
            $table->index('application_id');
            $table->index('scope');
            $table->index('school_institution_id');
            $table->index('school_level_id');
            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
