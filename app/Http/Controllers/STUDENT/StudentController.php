<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\StudentService;
use App\Models\Code;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

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
        if (preg_match("/(01)[0-9]{9}/", $request->post('user_login'))) {
            $cred = ["phone" => $request->post("user_login"), "password" => $request->post('password')];
        } else {
            if (!$student = Student::where('email', $request->post('user_login'))->first()) {
                return $this->response('', 'Please Check your Email or Phone', 422);
            }
            $cred = ["email" => $request->post("user_login"), "password" => $request->post('password')];
        }
        $token = Auth::attempt($cred);
        if (!$token) {
            return $this->response(null, 'Unauthorized', 401);
        }

        $student = Auth::user();
        if (!$student->status) {
            return $this->response(null, 'Forbidden to login because you are not active', 403);
        }

        $expireIn = Carbon::now(Config::get('app.timezone'))->addMinutes(Auth::factory()->getTTL());
        return $this->response(['student' => $student, 'Authorization' => ["token" => $token, 'expires_in' => $expireIn, "type" => "Bearer"]], 'Welcome back');
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        if (auth()->user()->id != $id) {
            return $this->response($student, 'You can`t edit this student', 400);
        }
        try {
            Student::where('id', $id)->update($request->all());
            $updatedStudent = Student::findOrFail($id);
            return $this->response($updatedStudent, 'Student Updated successfully', 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Student not updated', 400);
        }
    }

    public function logout()
    {
        Auth::logout();
        return $this->response(null, 'Student logged out successfully', 200);
    }

    public function reedemCode(Request $request)
    {
        $barCode = Code::where('barcode', $request->post('barcode'))->firstOrFail();
        $oldCode = Code::where('student_id', auth()->user()->id)->where('lesson_id', $request->post('lesson_id'))->where('status', Code::ACTIVE)->first();
        if ($oldCode) {
            return $this->response(null, 'student already reedem this lesson', 400);
        }
        
        if ($barCode && $barCode->student_id == null && $barCode->lesson_id == $request->post('lesson_id')) {
            $deactiveDate = ($barCode->deactive_at < Carbon::now(Config::get('app.timezone'))->addDays(3)) ? $barCode->deactive_at : Carbon::now(Config::get('app.timezone'))->addDays(3);
            $barCode->update([
                'student_id' => auth()->user()->id,
                'activated_at' => Carbon::now(Config::get('app.timezone')),
                'deactive_at' => $deactiveDate,
                'status' => Code::ACTIVE
            ]);
            $updatedBarCode = Code::where('barcode', $request->post('barcode'))->first();
            return $this->response($updatedBarCode, "Barcode is activated for $deactiveDate", 200);
        } else {
            return $this->response(null, 'Something went wrong', 400);
        }
    }
}
