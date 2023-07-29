<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function login(Request $request)
    {
        if (!$student = Student::where('email', $request->input('email'))->first()) {
            return $this->response('', 'Wrong Email', 500);
        }
        if (Hash::check($request->input('password'), $student->password)) {
            $token = $student->createToken('Super admin')->accessToken;
            return $this->response(['Student' => $student, 'token' => $token], 'Welcome back');
        }
        return $this->response('', 'Wrong Password', 500);
    }

    public function reedemCode(Request $request)
    {
        $barCode = Code::where('barcode', $request->post('barcode'))->first();
        $deactiveDate = ($barCode->deactive_at < Carbon::now()->addDays(3)) ? $barCode->deactive_at : Carbon::now()->addDays(3);
        if ($barCode && $barCode->student_id == null) {
            $barCode->update([
                'student_id' => 1,
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
}
