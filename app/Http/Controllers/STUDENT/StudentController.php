<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\StudentService;
use App\Models\Code;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    protected StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }
    public function register(Request $request)
    {
        $validate = $this->studentService->validateCreateStudent($request->all());

        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $student = $this->studentService->createStudent($request);

        $token = Auth::login($student);


        return $this->response(['student' => $student, 'Authorization' => ["token" => $token, "type" => "Bearer"]], "Student Created Successfully", 200);
    }

    public function login(Request $request)
    {
        if (!$student = Student::where('email', $request->post('email'))->first()) {
            return $this->response('', 'Wrong Email', 422);
        }
        $cred = $request->only("email", "password");
        $token = Auth::attempt($cred);
        if (!$token) {
            return $this->response(null, 'Unauthorized', 401);
        }

        $student = Auth::user();
        return $this->response(['student' => $student, 'Authorization' => ["token" => $token, "type" => "Bearer"]], 'Welcome back');
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (auth()->user()->id != $id) {
            return $this->response($student, 'You can`t edit this student', 400);
        }
        try {
            Student::where('id', $id)->update($request->all());
            $updatedStudent = Student::find($id);
            return $this->response($updatedStudent, 'Student Updated successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Student not updated', 400);
        }
    }

    public function logout()
    {
        Auth::logout();
        return $this->response(null, 'Student logged out successfully', 200);
    }

    public function reedemCode(Request $request)
    {
        $barCode = Code::where('barcode', $request->post('barcode'))->first();
        $deactiveDate = ($barCode->deactive_at < Carbon::now()->addDays(3)) ? $barCode->deactive_at : Carbon::now()->addDays(3);
        if ($barCode && $barCode->student_id == null) {
            $barCode->update([
                'student_id' => auth()->user()->id,
                'activated_at' => Carbon::now(),
                'deactive_at' => $deactiveDate,
                'status' => 'Activated'
            ]);
            $updatedBarCode = Code::where('barcode', $request->post('barcode'))->first();
            return $this->response($updatedBarCode, "Barcode is activated for $deactiveDate", 200);
        } else {
            return $this->response(null, 'Something went wrong', 404);
        }
    }
}
