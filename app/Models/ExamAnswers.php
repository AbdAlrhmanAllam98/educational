<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswers extends Model
{
    use HasFactory;
    protected $table = "student_exam_answers";

    protected $fillable = ["id", "student_id", "answer", "exam_id"];
}
