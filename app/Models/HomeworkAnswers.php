<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class HomeworkAnswers extends Model
{
    use HasFactory, HasUuids;
    protected $table = "student_homework_answers";

    protected $fillable = ["id", "student_id", "answer", "homework_id"];
}
