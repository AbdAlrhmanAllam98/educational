<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Code;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function store(){
        
    }
    public function generateCode()
    {
        do {
            $barcode = random_int(100000000000, 999999999999);
        } while (Code::where('barcode', $barcode)->first());
        return $barcode;
    }
}
