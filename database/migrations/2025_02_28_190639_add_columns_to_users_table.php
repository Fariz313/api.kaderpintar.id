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
            $table->string('photo_profile')->nullable()->after('email'); // Photo profile (nullable)
            $table->date('birth_date')->nullable()->after('photo_profile'); // Birth date (nullable)
            $table->string('mother_name')->nullable()->after('birth_date'); // Mother's name (nullable)
            $table->string('father_name')->nullable()->after('mother_name'); // Father's name (nullable)
            $table->string('parent_phone')->nullable()->after('father_name'); // Parent's phone (nullable)
            $table->text('address')->nullable()->after('parent_phone'); // Address (nullable)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'photo_profile',
                'birth_date',
                'mother_name',
                'father_name',
                'parent_phone',
                'address',
            ]);
        });
    }
};
