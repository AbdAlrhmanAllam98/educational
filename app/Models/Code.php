<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Code extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['barcode', 'student_id', 'activated_at', 'deactive_at', 'status', 'code_id'];

    protected $with = ['student'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function codeHistory()
    {
        return $this->belongsTo(CodeHistory::class, 'code_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->select('students.id', 'full_name');
    }
}
