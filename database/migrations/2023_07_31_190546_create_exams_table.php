<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('exams');
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string("exam_name");
            $table->integer("question_count")->default(0);
            $table->integer("full_mark");
            $table->foreignId('year_id')->constrained('years')->onDelete('CASCADE');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('CASCADE');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('CASCADE');
            $table->timestamp("exam_date_start")->default(now());
            $table->timestamp("exam_date_end")->default(Carbon::now()->addHours(2));
            $table->boolean('exam_status')->default(false);
            $table->boolean('result_status')->default(false);

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
