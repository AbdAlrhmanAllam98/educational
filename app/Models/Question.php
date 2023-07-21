<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['title_en', 'title_ar', 'correct_answer', 'year_id', 'semester_id', 'subject_id', 'leason_id'];

    public function leason(){
        return $this->belongsTo(Leason::class);
    }
}
