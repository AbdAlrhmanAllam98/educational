<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leason extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['id', 'name_en', 'name_ar', 'code', 'subject_code', 'status', 'video_path', 'created_by', 'updated_by'];

    protected $with = ['createdBy'];

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
        return $this->belongsTo(Homework::class);
    }
    public function codesHistory()
    {
        return $this->hasMany(CodeHistory::class, 'leason_id', 'id')->select('id', 'count', 'leason_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select('id','user_name');
    }
}
