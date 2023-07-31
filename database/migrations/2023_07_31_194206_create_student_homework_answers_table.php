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
        Schema::create('student_homework_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("students")->onDelete("CASCADE");
            $table->string("answer", 1);
            $table->foreignId("homework_question_id")->constrained("homework_question")->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_homework_answers');
    }
};
