<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name_en', 'name_ar', 'image_path', 'year_id', 'semester_id', 'subject_id', 'leason_id', 'code', 'correct_answer'];
    protected $hidden = ['pivot', 'correct_answer', 'created_at', 'updated_at'];

    public function leason()
    {
        return $this->belongsTo(Leason::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_question', 'question_id', 'exam_id');
    }
    public function homework()
    {
        return $this->belongsToMany(Homework::class);
    }
}
