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
        Schema::dropIfExists('questions');
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('name_en')->unique();
            $table->string('name_ar')->unique();
            $table->string('correct_answer', 1);
            $table->string('image_path')->nullable();

            $table->string('subject_code');
            $table->foreign('subject_code')->references('code')->on('subjects')->onDelete('CASCADE');
            $table->uuid('leason_id');
            $table->foreign('leason_id')->references('id')->on('leasons')->onDelete('CASCADE');

            $table->uuid('created_by');
            $table->uuid('updated_by');
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
        Schema::dropIfExists('questions');
    }
};
