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
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->string("homework_name");
            $table->integer("question_count")->default(0);
            $table->integer("full_mark");
            $table->foreignId('year_id')->constrained('years')->onDelete('CASCADE');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('CASCADE');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('CASCADE');
            $table->foreignId('leason_id')->constrained('leasons')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
};
