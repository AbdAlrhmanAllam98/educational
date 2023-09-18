<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['id', 'name', 'code', 'subject_code', 'status', 'video_path', 'video_from', 'video_to', 'type', 'created_by', 'updated_by'];

    protected $with = ['homework'];

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
        return $this->hasOne(Homework::class)->select('id', 'homework_name', 'question_count', 'full_mark', 'lesson_id');
    }
    public function codesHistory()
    {
        return $this->hasMany(CodeHistory::class, 'lesson_id', 'id')->select('id', 'count', 'lesson_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select('id', 'user_name');
    }
}
