<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(){
        $subjects = Subject::with(['semester'])->get();
        return $this->response($subjects,'All Subjects retrived successfully',200);
    }
}
