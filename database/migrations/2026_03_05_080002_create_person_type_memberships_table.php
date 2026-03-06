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
        Schema::create('person_type_memberships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('person_id')
                  ->constrained('persons')
                  ->onDelete('cascade');
            $table->foreignUuid('person_type_id')
                  ->constrained('person_types')
                  ->onDelete('cascade');
            $table->date('joined_date')->nullable();
            $table->date('left_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplicate membership
            $table->unique(['person_id', 'person_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_type_memberships');
    }
};
