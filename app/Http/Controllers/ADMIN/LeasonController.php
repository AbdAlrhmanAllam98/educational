<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminService;
use App\Models\Leason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeasonController extends Controller
{
    protected AdminService $leasonService;

    public function __construct(AdminService $leasonService)
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
        $validate = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required',
            'year_id' => 'required|numeric|min:1|max:3',
            'semester_id' => 'required|numeric|min:1|max:2',
            'subject_id' => 'required|numeric|min:1|max:5',
        ]);
        if($validate->fails()){
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 400);
        }

        $semesterId = $this->leasonService->mappingSemester($request->year_id, $request->semester_id);
        $subjectId = $this->leasonService->mappingSubject($semesterId, $request->subject_id);

        $leason = Leason::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'year_id' => $request->year_id,
            'semester_id' => $semesterId,
            'subject_id' => $subjectId,
        ]);
        return $this->response($leason, 'Leason created successfully', 201);
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
