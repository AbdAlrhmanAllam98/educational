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

    public function indexForReedemed(Request $request)
    {
        $codes = $this->codeService->getReedemedCodes($request);
        return $this->response($codes, 'Reedemed Codes retrieved successfully');
    }

    public function indexForNew(Request $request)
    {
        $codes = $this->codeService->getNewCodes($request);
        return $this->response($codes, 'New Codes retrieved successfully');
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
