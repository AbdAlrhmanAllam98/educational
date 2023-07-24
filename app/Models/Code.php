<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $fillable = ['barcode', 'student_id', 'activated_at', 'status', 'code_id'];

    public function leason()
    {
        return $this->belongsTo(Leason::class);
    }

    public function codeHistory(){
        return $this->belongsTo(CodeHistory::class,'code_id','id');
    }
}
