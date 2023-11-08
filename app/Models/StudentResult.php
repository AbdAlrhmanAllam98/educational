<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class StudentResult extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['student_id', 'exam_id', 'result'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
