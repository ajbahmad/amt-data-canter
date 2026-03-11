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
        Schema::create('id_cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('school_institution_id')->nullable()->foreign('school_institution_id')
                  ->references('id')
                  ->on('school_institutions')
                  ->onDelete('set null');
            $table->uuid('school_level_id')->nullable()->foreign('school_level_id')
                  ->references('id')
                  ->on('school_levels')
                  ->onDelete('set null');
            // UID unik dari RFID reader
            $table->string('card_uid', 100)->unique();

            // nomor kartu tercetak (opsional)
            $table->string('card_number', 100)->nullable();

            // kartu dimiliki oleh person tertentu
            $table->uuid('person_id');

            // status kartu
            $table->string('status', 20)->default('active'); // active, lost, blocked, expired

            $table->dateTime('issued_at')->nullable();
            $table->dateTime('expired_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
            $table->index('person_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_cards');
    }
};
