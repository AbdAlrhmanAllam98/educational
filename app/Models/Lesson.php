<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['id', 'name', 'code', 'subject_code', 'status', 'video_path', 'video_from', 'video_to', 'type', 'created_by', 'updated_by'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function homework()
    {
        return $this->hasOne(Homework::class)->select('id', 'homework_name', 'question_count', 'lesson_id');
    }
    public function codes()
    {
        return $this->hasMany(Code::class);
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
