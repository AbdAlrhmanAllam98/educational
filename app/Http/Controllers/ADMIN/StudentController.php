<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\StudentService;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
        $this->middleware('auth:api_admin');
    }

    public function index(Request $request)
    {
        $students = $this->studentService->getStudents($request);
        return $this->response($students, "All Students retrieved successfully", 200);
    }

    public function show($id)
    {
        $student = Student::with(['codes', 'studentResult'])->findOrFail($id);
        return $this->response($student, "Student retrieved successfully", 200);
    }

    public function update(Request $request, $id)
    {
        try {
            Student::where('id', $id)->update($request->all());
            $updatedStudent = Student::findOrFail($id);
            return $this->response($updatedStudent, "Student Updated successfully", 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Student Failed to Update', 400);
        }
    }

    public function delete($id)
    {
        try {
            Student::findOrFail($id)->delete();
            return $this->response(null, 'Student Deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Student Failed to Delete', 400);
        }
    }
}
