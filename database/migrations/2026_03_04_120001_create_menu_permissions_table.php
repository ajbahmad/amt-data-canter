<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration: Menu Permissions Table
     *
     * Tujuan:
     * - Menentukan role/permission mana yang boleh melihat menu tertentu
     * - Mendukung multi-role per menu item
     *
     * Konsep:
     * - Relasi many-to-many antara menu dan roles
     * - role_code mengacu ke sistem role di auth service
     * - Jika tidak ada record untuk menu, semua role bisa melihat (atau sebaliknya)
     */

    public function up(): void
    {
        Schema::create('menu_permissions', function (Blueprint $table) {
            // UUID primary key
            $table->uuid('id')->primary();

            // Relasi ke menu
            $table->uuid('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->cascadeOnDelete();
            $table->index('menu_id');

            /**
             * role_code:
             * Kode role yang boleh akses menu
             * Contoh: super-admin, admin, teacher, student, parent
             *
             * Harus sesuai dengan sistem role di auth service
             */
            $table->string('role_code', 50);
            $table->index('role_code');

            /**
             * can_view:
             * Bisa melihat menu
             */
            $table->boolean('can_view')->default(true);

            /**
             * can_create:
             * Bisa membuat data (opsional, untuk granular permission)
             */
            $table->boolean('can_create')->default(false);

            /**
             * can_edit:
             * Bisa mengedit data
             */
            $table->boolean('can_edit')->default(false);

            /**
             * can_delete:
             * Bisa menghapus data
             */
            $table->boolean('can_delete')->default(false);

            $table->timestamps();

            // Mencegah duplikasi role yang sama pada menu yang sama
            $table->unique(['menu_id', 'role_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_permissions');
    }
};
