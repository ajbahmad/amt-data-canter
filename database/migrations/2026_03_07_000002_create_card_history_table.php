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
        Schema::create('card_history', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('id_card_id');
            $table->uuid('person_id');

            // issued, blocked, lost, replaced, unblocked, expired
            $table->string('action', 50);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('id_card_id')->references('id')->on('id_cards')->cascadeOnDelete();
            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();

            $table->index('id_card_id');
            $table->index('person_id');
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_history');
    }
};
