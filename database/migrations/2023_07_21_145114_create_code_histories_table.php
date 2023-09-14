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
        Schema::dropIfExists('code_histories');
        Schema::create('code_histories', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->integer("count");

            $table->string('subject_code');
            $table->foreign('subject_code')->references('code')->on('subjects')->onDelete('CASCADE');
            $table->uuid('leason_id');
            $table->foreign('leason_id')->references('id')->on('leasons')->onDelete('CASCADE');

            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
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
        Schema::dropIfExists('code_histories');
    }
};