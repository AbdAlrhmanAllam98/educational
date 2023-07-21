<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leason extends Model
{
    use HasFactory;
    protected $fillable = ['title_en', 'title_ar', 'year_id', 'semester_id', 'subject_id'];

    protected $with = ['questions'];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function questions(){
        return $this->hasMany(Question::class);
    }
}
