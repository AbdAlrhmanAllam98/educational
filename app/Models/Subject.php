<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory,HasUuids;

    protected $with = ['leasons'];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function leasons()
    {
        return $this->hasMany(Leason::class);
    }
}
