<?php

use Carbon\Carbon;
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
        Schema::dropIfExists('exams');
        Schema::create('exams', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string("exam_name");
            $table->integer("question_count")->default(0);
            $table->integer("full_mark");

            $table->string('subject_code');
            $table->foreign('subject_code')->references('code')->on('subjects')->onDelete('CASCADE');

            $table->timestamp("exam_date_start")->default(now());
            $table->timestamp("exam_date_end")->default(Carbon::now()->addHours(2));
            $table->boolean('exam_status')->default(false);
            $table->boolean('result_status')->default(false);

            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');

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
