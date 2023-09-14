<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['student_id', 'exam_id', 'homework_id', 'result', 'type'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
