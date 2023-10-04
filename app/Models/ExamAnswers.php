<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ExamAnswers extends Model
{
    use HasFactory, HasUuids;
    protected $table = "student_exam_answers";

    protected $fillable = ["id", "student_id", "answer", "exam_id"];
}
