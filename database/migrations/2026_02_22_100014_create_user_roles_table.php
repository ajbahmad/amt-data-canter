<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('role_id');
            
            // Scope-based organization context
            $table->uuid('school_institution_id')->nullable();
            $table->uuid('school_level_id')->nullable();
            
            $table->uuid('assigned_by_id')->nullable();
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('school_institution_id')
                ->references('id')
                ->on('school_institutions')
                ->onDelete('set null');

            $table->foreign('school_level_id')
                ->references('id')
                ->on('school_levels')
                ->onDelete('set null');

            $table->foreign('assigned_by_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->unique(['user_id', 'role_id', 'school_institution_id', 'school_level_id']);
            $table->index('user_id');
            $table->index('role_id');
            $table->index('school_institution_id');
            $table->index('school_level_id');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
