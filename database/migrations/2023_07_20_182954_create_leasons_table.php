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
        Schema::dropIfExists('leasons');
        Schema::create('leasons', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('year_id')->references('id')->on('years')->cascadeOnDelete();
            $table->foreign('semester_id')->references('id')->on('semesters')->cascadeOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leasons');
    }
};
