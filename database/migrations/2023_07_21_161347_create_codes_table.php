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
        Schema::dropIfExists('codes');
        Schema::create('codes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->date('activated_at')->nullable();
            $table->date('deactive_at')->nullable();
            $table->string('barcode');
            $table->string('status');   //Initialize, Activated , Deactivated
            $table->uuid('code_id');
            $table->foreign('code_id')->references('id')->on('code_histories')->onDelete('CASCADE');
            $table->uuid('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
