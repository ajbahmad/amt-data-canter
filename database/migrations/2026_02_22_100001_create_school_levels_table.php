<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tujuan:
     * - Menyimpan daftar level sekolah (SD, SMP, SMA, SMK, dll)
     * - Setiap level sekolah memiliki structure akademik tersendiri
     */
    public function up(): void
    {
        Schema::create('school_levels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();


            // kode unik level (sd, smp, sma, smk)
            $table->string('code', 20)->unique();

            // nama level (SD, SMP, SMA, SMK)
            $table->string('name', 50);

            // deskripsi (opsional)
            $table->text('description')->nullable();

            // status aktif/tidak
            $table->boolean('is_active')->default(true);

            // Unique constraint: name per institution
            $table->unique(['school_institution_id', 'name']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_levels');
    }
};
