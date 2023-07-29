<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name', 'email', 'birth_date', 'phone', 'parent_phone', 'national_id', 'status', 'year_id', 'semester_id'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function codes()
    {
        return $this->hasMany(Code::class, 'student_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}
