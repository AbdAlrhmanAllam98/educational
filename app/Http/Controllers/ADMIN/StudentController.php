<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return $this->response($students, "All Students retrieved successfully", 200);
    }

    public function show($id)
    {
        $student = Student::with(['codes'])->findOrFail($id);
        return $this->response($student, "Student retrieved successfully", 200);
    }
}
