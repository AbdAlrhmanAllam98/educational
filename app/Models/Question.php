<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Question extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['id', 'image_path', 'subject_code', 'lesson_id', 'sort_order', 'correct_answer', 'created_by', 'updated_by'];
    protected $hidden = ['pivot', 'correct_answer', 'created_at', 'updated_at'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'lesson_id','id')->select('lessons.id', 'name');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_question', 'question_id', 'exam_id');
    }
    public function homework()
    {
        return $this->belongsToMany(Homework::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select('id', 'user_name');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id')->select('id', 'user_name');
    }
}
