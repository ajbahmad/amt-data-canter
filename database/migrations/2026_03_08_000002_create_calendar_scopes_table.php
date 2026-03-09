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
        Schema::create('calendar_scopes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('calendar_id');
            $table->uuid('school_institution_id')->nullable();
            $table->uuid('school_level_id')->nullable();
            $table->uuid('class_room_id')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('calendar_id')
                ->references('id')
                ->on('calendars')
                ->onDelete('cascade');
            
            $table->foreign('school_institution_id')
                ->references('id')
                ->on('school_institutions')
                ->onDelete('set null');
            
            $table->foreign('school_level_id')
                ->references('id')
                ->on('school_levels')
                ->onDelete('set null');
            
            $table->foreign('class_room_id')
                ->references('id')
                ->on('class_rooms')
                ->onDelete('set null');
            
            // Indexes
            $table->index('calendar_id');
            $table->index('school_institution_id');
            $table->index('school_level_id');
            $table->index('class_room_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_scopes');
    }
};
