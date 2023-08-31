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
            $table->string('name_en')->unique();
            $table->string('name_ar')->unique();
            $table->string('code');
            $table->foreign('code')->references('code')->on('subjects')->onDelete('CASCADE');

            $table->foreignId('year_id')->constrained('years')->onDelete('CASCADE');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('CASCADE');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('CASCADE');

            $table->boolean('status')->default(false);
            $table->string('video_path')->nullable();
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
