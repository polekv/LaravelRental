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
        // Changed Route::table to Schema::table
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email'); // Regular users by default
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Changed Route::table to Schema::table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};