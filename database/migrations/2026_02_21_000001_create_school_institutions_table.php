<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_institutions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // kode internal unik sekolah (misal: SMPN1_BDG)
            $table->string('code', 50)->unique();

            // nama sekolah
            $table->string('name');

            // NPSN sekolah (opsional)
            $table->string('npsn', 20)->nullable();

            $table->text('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();

            // menandakan sekolah aktif atau tidak
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_institutions');
    }
};
