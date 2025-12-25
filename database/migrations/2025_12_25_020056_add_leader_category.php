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
            $table->string('leader_category')->nullable()->unique()->after('role');
            // unique() works because NULL can repeat.
            // Only leaders will have a value; others stay NULL.
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['leader_category']);
            $table->dropColumn('leader_category');
        });
    }
};
