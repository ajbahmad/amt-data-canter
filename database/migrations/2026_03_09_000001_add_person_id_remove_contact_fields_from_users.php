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
        Schema::table('users', function (Blueprint $table) {
            // Add person_id column before dropping phone/address
            $table->foreignUuid('person_id')->nullable()->after('email')->constrained('persons')->onDelete('set null');
            
            // Drop phone and address columns
            $table->dropColumn(['phone', 'address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore phone and address columns
            $table->string('phone', 20)->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            
            // Drop person_id foreign key and column
            $table->dropForeignIdFor(\App\Models\Person::class);
            $table->dropColumn('person_id');
        });
    }
};
