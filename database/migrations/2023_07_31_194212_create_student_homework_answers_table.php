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
        Schema::dropIfExists('student_homework_answers');
        Schema::create('student_homework_answers', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string("answer");

            $table->uuid('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('CASCADE');

            $table->uuid('homework_id');
            $table->foreign('homework_id')->references('id')->on('homework')->onDelete('CASCADE');

            $table->unique(['student_id','homework_id']);

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
