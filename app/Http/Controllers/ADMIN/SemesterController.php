<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index(){
        $semesters = Semester::all();
        return $this->response($semesters,'All Semesters retrived successfully',200);
    }
}
