<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new columns without touching existing ones

            // First & Last name
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');

            // Unique military badge number
            $table->string('badge_number')->unique()->after('last_name');

            // Division assignment
            $table->string('division')->nullable()->after('badge_number');

            // Role: 1=Admin, 2=Leader, 3=User
            $table->tinyInteger('role')->after('division');
            // Last login timestamp
            $table->timestamp('last_login_at')->nullable()->after('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'badge_number',
                'division',
                'role',
                'last_login_at',
            ]);
        });
    }
};
