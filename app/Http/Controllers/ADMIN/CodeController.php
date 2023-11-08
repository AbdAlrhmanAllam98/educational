<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\CodeService;
use App\Models\Code;
use App\Models\CodeHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CodeController extends Controller
{
    protected CodeService $codeService;

    public function __construct(CodeService $codeService)
    {
        $this->codeService = $codeService;
        $this->middleware('auth:api_admin');
    }

    public function index(Request $request)
    {
        $codesHistory = $this->codeService->getCodes($request);
        $reedemedCode = [];
        $newCode = [];
        foreach ($codesHistory as $historyKey => $historyValue) {
            foreach ($historyValue->codes as $codesKey => $codesValue) {
                if ($codesValue->student_id != null) {
                    array_push($reedemedCode, $codesValue);
                } else {
                    array_push($newCode, $codesValue);
                }
            }
        }
        return $this->response(['reedemed' => $reedemedCode, 'new' => $newCode], 'All Codes retrieved successfully');
    }

    public function generateNewCodes(Request $request)
    {
        $validate = $this->codeService->validateGeneration($request);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $codeHistory = $this->codeService->createCodeHistory($request);

        $codesArray = [];
        for ($i = 0; $i < $request->post('count'); $i++) {
            do {
                $barcode = random_int(100000, 9999999);
            } while (Code::where('barcode', $barcode)->first());
            $code = Code::create([
                'barcode' => $barcode,
                'code_id' => $codeHistory->id,
                'status' => 'initialized',
                'deactive_at' => Carbon::now(Config::get('app.timezone'))->addDays(7),
                'created_by' => auth('api_admin')->user()->id
            ]);
            array_push($codesArray, $code);
        }
        $codeHistory = CodeHistory::findOrFail($codeHistory->id);
        return $this->response($codeHistory->codes, 'Codes Generated Successfully', 200);
    }
}
