<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function codes()
    {
        return $this->hasMany(Code::class,'student_id','id');
    }
}
