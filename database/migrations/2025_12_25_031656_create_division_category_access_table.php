<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('division_category_access', function (Blueprint $table) {
            $table->id();
            $table->string('division');
            $table->string('category'); // slug: admin, personnel-services, etc
            $table->timestamps();

            $table->unique(['division', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('division_category_access');
    }
};
