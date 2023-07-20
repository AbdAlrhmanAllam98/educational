<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(){
        $subjects = Subject::get();
        return $this->response($subjects,'All Subjects retrived successfully',200);
    }
    public function show($id){
        $subject = Subject::findOrFail($id);
        return $this->response($subject,'Subject data retrived successfully',200);
    }
}
