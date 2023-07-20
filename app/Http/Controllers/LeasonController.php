<?php

namespace App\Http\Controllers;

use App\Http\Services\LeasonService;
use App\Models\Leason;
use Illuminate\Http\Request;

class LeasonController extends Controller
{
    protected LeasonService $leasonService;

    public function __construct(LeasonService $leasonService)
    {
        $this->leasonService = $leasonService;
    }

    public function index()
    {
        $leasons = Leason::all();
        return $this->response($leasons, 'All Leasons retrived successfully', 200);
    }
    public function show($id)
    {
        $leason = Leason::findOrFail($id);
        return $this->response($leason, 'The Leason retrived successfully', 200);
    }
    public function store(Request $request)
    {
        $semesterId = $this->leasonService->mappingSemester($request->year_id, $request->semester_id);
        $leason = new Leason();
        $leason->title_en = $request->title_en;
        $leason->title_ar = $request->title_ar;
        $leason->year_id = $request->year_id;
        $leason->semester_id = $semesterId;
        $leason->subject_id = $this->leasonService->mappingSubject($semesterId, $request->subject_id);
        $leason->save();
        return $this->response($leason, 'Leason created successfully', 200);
    }
    public function update(Request $request, $id)
    {
        $updatedLeason = Leason::where('id', $id)->update($request->all());
        return $this->response($updatedLeason, 'Leason Updated successfully', 200);
    }
    public function delete($id)
    {
        Leason::find($id)->delete();
        return $this->response(null, 'Leason Deleted successfully', 200);
    }
}
