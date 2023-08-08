<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'exercise_name', 'full_mark' ,'question_count', 'year_id', 'semester_id', 'subject_id','exercise_date'];
    protected $dates = ['exercise_date', 'created_at', 'updated_at'];
    protected $with = ['questions'];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
