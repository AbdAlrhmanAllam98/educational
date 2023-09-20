<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'exam_name', 'full_mark', 'question_count', 'subject_code', 'exam_date_start', 'exam_date_end', 'exam_status', 'result_status', 'created_by', 'updated_by'];
    protected $dates = ['exam_date_start', 'exam_date_end', 'created_at', 'updated_at'];
    protected $with = ['questions'];
    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_question', 'exam_id', 'question_id')->select('question.id', 'image_path', 'sort_order','correct_answer');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select('id', 'user_name');
    }
}
