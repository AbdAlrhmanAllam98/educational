<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['title_en', 'title_ar', 'correct_answer', 'year_id', 'semester_id', 'subject_id', 'leason_id'];

    public function leason()
    {
        return $this->belongsTo(Leason::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
    public function homework()
    {
        return $this->belongsToMany(Homework::class);
    }
}
