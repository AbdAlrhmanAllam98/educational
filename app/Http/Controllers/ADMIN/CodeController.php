<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\CodeHistory;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function generateNewCode(Request $request)
    {
        $codeHistory = CodeHistory::create([
            'count' => $request->post('count'),
            'year_id' => $request->post('year_id'),
            'semester_id' => $request->post('semester_id'),
            'subject_id' => $request->post('subject_id'),
            'leason_id' => $request->post('leason_id'),
            'admin_id' => 1,
        ]);
        $codesArray = [];
        for ($i = 0; $i < $request->post('count'); $i++) {
            do {
                $barcode = random_int(100000, 9999999);
            } while (Code::where('barcode', $barcode)->first());
            $code = Code::create([
                'barcode' => $barcode,
                'code_id' => $codeHistory->id,
                'status' => 'initialized'
            ]);
            array_push($codesArray, $code);
        }
        return $this->response($codesArray, 'Codes Generated Successfully', 200);
    }
    public function index(Request $request){
        $codes =Code::paginate($request->get('per_page') ?? 10);
        return $this->response($codes, 'All Codes retrived Successfully', 200);
    }
}
