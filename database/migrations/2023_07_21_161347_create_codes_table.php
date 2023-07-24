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
        Schema::dropIfExists('codes');
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->nullable();
            $table->date('activated_at')->nullable();
            $table->string('barcode');
            $table->string('status');   //Initialize, Activated , Deactivated
            $table->foreignId('code_id')->constrained('code_histories')->onDelete('CASCADE');
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
