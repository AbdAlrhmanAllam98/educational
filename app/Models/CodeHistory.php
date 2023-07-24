<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeHistory extends Model
{
    use HasFactory;
    protected $fillable = ['count','admin_id','year_id', 'semester_id', 'subject_id', 'leason_id'];

    public function leason(){
        return $this->belongsTo(Leason::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
