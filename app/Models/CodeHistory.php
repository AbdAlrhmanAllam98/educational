<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CodeHistory extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['count', 'subject_code', 'lesson_id', 'created_by', 'updated_by'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    public function codes()
    {
        return $this->hasMany(Code::class, 'code_id', 'id')->select('id', 'barcode', 'status', 'student_id', 'code_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select('id', 'user_name');
    }
}
