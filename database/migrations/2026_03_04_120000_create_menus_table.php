<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration: Menus Table
     *
     * Tujuan:
     * - Menyimpan konfigurasi menu sidebar secara dinamis di database
     * - Mendukung menu dropdown (accordion) dan menu item biasa
     * - Struktur hierarchical dengan parent_id untuk submenu
     *
     * Konsep:
     * - Menggunakan UUID primary key untuk konsistensi dengan aplikasi
     * - parent_id untuk self-relation (menu parent → submenu)
     * - type: 'dropdown' untuk menu accordion, 'item' untuk menu biasa
     * - menu_key untuk identifikasi unik dropdown accordion
     * - order_no untuk sorting menu pada sidebar
     */

    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            // UUID primary key
            $table->uuid('id')->primary();

            /**
             * parent_id:
             * - null = menu root (item di root level)
             * - not null = submenu dari menu parent tertentu
             */
            $table->uuid('parent_id')->nullable();

            /**
             * type:
             * - 'item' = menu biasa (punya route/url)
             * - 'dropdown' = menu accordion yang punya children
             */
            $table->string('type', 20)->default('item'); // item, dropdown
            $table->index('type');

            // Title yang ditampilkan pada sidebar
            $table->string('title', 150);

            /**
             * icon:
             * Icon untuk menu (contoh: solar:book-bookmark-line-duotone)
             * Support untuk berbagai icon library (ionicon, solar, tabler, etc)
             */
            $table->string('icon', 150)->nullable();

            /**
             * color:
             * Warna badge/label untuk dropdown
             * Contoh: blue, indigo, purple, pink, red, orange, yellow, green
             */
            $table->string('color', 30)->default('blue');

            /**
             * menu_key:
             * Identifikasi unik untuk accordion dropdown
             * Contoh: master-data, academic, reporting
             * Hanya digunakan jika type='dropdown'
             */
            $table->string('menu_key', 150)->unique()->nullable();
            $table->index('menu_key');

            /**
             * route:
             * Nama route Laravel
             * Contoh: admin.students.index
             * Hanya digunakan jika type='item'
             */
            $table->string('route', 200)->nullable();
            $table->index('route');

            /**
             * url:
             * URL manual (opsional, alternatif jika tidak pakai route)
             * Contoh: /admin/dashboard
             */
            $table->string('url', 255)->nullable();

            /**
             * order_no:
             * Urutan tampilan menu pada sidebar
             * Semakin kecil, semakin atas
             */
            $table->unsignedInteger('order_no')->default(0);
            $table->index('order_no');

            /**
             * description:
             * Deskripsi menu (opsional, untuk tooltip/help)
             */
            $table->text('description')->nullable();

            /**
             * badge:
             * Badge/label tambahan (contoh: "NEW", "5", notifikasi count)
             */
            $table->string('badge', 100)->nullable();

            /**
             * badge_color:
             * Warna badge (red, green, blue, yellow, etc)
             */
            $table->string('badge_color', 30)->nullable();

            /**
             * is_active:
             * Menu aktif atau tidak
             */
            $table->boolean('is_active')->default(true);
            $table->index('is_active');

            $table->timestamps();
        });

        // Add foreign key in separate schema call for PostgreSQL compatibility
        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('menus')
                  ->nullOnDelete();
            $table->index(['parent_id', 'is_active']);
            $table->index(['parent_id', 'order_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
