<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class StudentResult extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['student_id', 'exam_id', 'result'];
    protected $hidden = ['pivot', 'created_at', 'updated_at'];


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id')->select('exams.id', 'exams.exam_name');
    }
}
