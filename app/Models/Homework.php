<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Homework extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'id', 'homework_name', 'question_count', 'subject_code', 'lesson_id', 'created_by', 'updated_by'
    ];
    protected $dates = ['homework_date', 'created_at', 'updated_at'];
    protected $with = ['questions'];

    public function questions()
    {
        return $this->belongsToMany(Question::class)->select(['questions.id', 'image_path', 'sort_order', 'correct_answer'])->orderBy('sort_order', 'asc');
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
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
