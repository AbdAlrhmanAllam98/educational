<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'homework_name', 'full_mark', 'question_count',
        'year_id', 'semester_id', 'subject_id', 'leason_id'
    ];
    protected $dates = ['homework_date', 'created_at', 'updated_at'];
    protected $with = ['questions'];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
    public function leason()
    {
        return $this->belongsTo(Leason::class);
    }
}
