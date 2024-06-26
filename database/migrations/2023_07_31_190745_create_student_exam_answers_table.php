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
        Schema::dropIfExists('student_exam_answers');
        Schema::create('student_exam_answers', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string("answer");

            $table->uuid('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('CASCADE');

            $table->uuid('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('CASCADE');

            $table->unique(['student_id','exam_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exam_answers');
    }
};
