<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Code extends Model
{
    use HasFactory, HasUuids;

    const INITIALIZE = 'initialize';
    const ACTIVE = 'active';
    const DEACTIVE = 'deactive';

    protected $fillable = ['barcode', 'student_id', 'activated_at', 'deactive_at', 'status', 'subject_code', 'lesson_id', 'created_by'];

    protected $with = ['student', 'createdBy'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->select('students.id', 'full_name');
    }
    
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select('id', 'user_name');
    }
}
