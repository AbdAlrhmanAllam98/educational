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
        Schema::dropIfExists('student_results');
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("students")->onDelete("CASCADE");
            $table->foreignId("exam_id")->constrained("exams")->onDelete("CASCADE");
            $table->double("result");
            $table->enum("type", ['exam', 'homework']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};
