<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory, HasUuids;
    // protected $with=['semesters'];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
