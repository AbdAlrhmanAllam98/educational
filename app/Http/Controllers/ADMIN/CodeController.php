<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\CodeService;
use App\Models\Code;
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
        $codes = $this->codeService->getCodes($request);
        $reedemedCode = [];
        $newCode = [];
        foreach ($codes as $codeKey => $codeValue) {
            if ($codeValue->student_id != null) {
                array_push($reedemedCode, $codeValue);
            } else {
                array_push($newCode, $codeValue);
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

        $codes = $this->codeService->createCodes($request);

        return $this->response($codes, 'Codes Generated Successfully', 200);
    }
}
