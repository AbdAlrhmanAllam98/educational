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
        Schema::dropIfExists('students');
        Schema::create('students', function (Blueprint $table) {
            Schema::dropIfExists('students');
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->date('birth_date');
            $table->string('phone')->unique();
            $table->string('parent_phone')->unique();
            $table->string('national_id')->nullable()->unique();
            $table->boolean('status')->default(true);
            $table->foreignId('year_id')->constrained('years')->onDelete('CASCADE');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
