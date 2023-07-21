<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $fillable = ['barcode', 'student_id', 'year_id', 'semester_id', 'subject_id', 'leason_id'];

    public function leason(){
        return $this->belongsTo(Leason::class);
    }
}
