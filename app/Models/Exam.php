<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'exam_name', 'full_mark', 'question_count', 'year_id', 'semester_id', 'subject_id','exam_date' ,'exam_status', 'result_status'];
    protected $dates = ['exam_date', 'created_at', 'updated_at'];
    protected $with = ['questions'];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
