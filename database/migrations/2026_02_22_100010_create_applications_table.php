<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('logo_url', 255)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->string('api_base_url', 255)->nullable();
            $table->string('api_client_id', 100)->unique()->nullable();
            $table->string('api_client_secret_hash', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
            $table->index('api_client_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
