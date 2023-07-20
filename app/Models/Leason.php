<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leason extends Model
{
    use HasFactory;
    protected $fillable = ['titl_en', 'title_ar', 'year_id', 'semester_id', 'subject_id'];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
