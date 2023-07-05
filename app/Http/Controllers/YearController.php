<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index():JsonResponse
    {
        $years = Year::all();
        return $this->response($years,'All Years Retrived Successfully',200);
    }
}
