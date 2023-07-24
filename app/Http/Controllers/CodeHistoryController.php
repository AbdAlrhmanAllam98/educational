<?php

namespace App\Http\Controllers;

use App\Models\CodeHistory;
use Illuminate\Http\Request;

class CodeHistoryController extends Controller
{
    // public function index($yearId,$semesterId,$subjectId,$leasonId){
    // }
    
    public function index(Request $request){
        $codesHistory = CodeHistory::where([
            ['year_id',$request->post('year_id')],
            ['semester_id',$request->post('semester_id')],
            ['subject_id',$request->post('subject_id')],
            ['leason_id',$request->post('leason_id')],
        ])->get();
        return $codesHistory;

    }
}
