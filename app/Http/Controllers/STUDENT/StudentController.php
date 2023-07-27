<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Models\Code;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function reedemCode(Request $request)
    {
        $barCode = Code::where('barcode', $request->post('barcode'))->first();
        if ($barCode && $barCode->student_id === null) {
            $barCode->update([
                'student_id' => auth()->user()->id,
                'activated_at' => now(),
                'status' => 'Activated'
            ]);
            return $this->response(null, 'Barcode is activated for ... Days', 200);
        } else {
            return $this->response(null, 'Something went wrong', 404);
        }
    }
}
