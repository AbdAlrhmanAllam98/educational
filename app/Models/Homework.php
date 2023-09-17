<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'id', 'homework_name', 'full_mark', 'question_count', 'subject_code', 'lesson_id', 'created_by', 'updated_by'
    ];
    protected $dates = ['homework_date', 'created_at', 'updated_at'];
    protected $with = ['questions'];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
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
