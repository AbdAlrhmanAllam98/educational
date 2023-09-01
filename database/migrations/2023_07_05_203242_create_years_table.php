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
        Schema::dropIfExists('years');
        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->unique();
            $table->string('name_ar')->unique();
            $table->string('code')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('years');
    }
};
