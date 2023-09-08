<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('semesters');
        Schema::create('semesters', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            // $table->string('name_en');
            // $table->string('name_ar');
            // $table->enum('type', ['GENERAL', 'LITERARY', 'SCIENTIFIC']);
            $table->string('code')->unique();
            $table->string('year_code');
            $table->foreign('year_code')->references('code')->on('years')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
