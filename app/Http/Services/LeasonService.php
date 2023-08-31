<?php

namespace App\Http\Services;

use App\Models\Leason;
use Illuminate\Support\Facades\Validator;


class LeasonService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getLeasons($input)
    {
        $q = Leason::latest();
        $query = $this->search($q, $input);

        return $this->search($query, $input)->paginate($input['per_page'] ?? 10);
    }
    public function search($q, $input)
    {
        $semesterId = null;
        if (isset($input['year_id']) && $input['year_id']) {
            $q->Where('year_id', $input->year_id);
        }
        if (isset($input['semester_id']) && $input['semester_id']) {
            $semesterId = $this->adminService->mappingSemester($input->year_id, $input->semester_id);
            $q->Where('semester_id', $semesterId);
        }
        if (isset($input['subject_id']) && $input['subject_id']) {
            $subjectId = $this->adminService->mappingSubject($semesterId, $input->subject_id);
            $q->Where('subject_id', $subjectId);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('name_ar', 'ilike', '%' . $input['search_term'] . '%');
        }
        return $q;
    }
    public function validateLeason($request)
    {
        return Validator::make($request->all(), [
            'name_en' => 'required|unique:leasons,name_en',
            'name_ar' => 'required|unique:leasons,name_ar',
            'year_id' => 'required|numeric|min:1|max:3',
            'semester_id' => 'required|numeric|min:1|max:2',
            'subject_id' => 'required|numeric|min:1|max:5',
        ]);
    }
    public function createLeason($request)
    {
        $semesterId = $this->adminService->mappingSemester($request->year_id, $request->semester_id);
        $subjectId = $this->adminService->mappingSubject($semesterId, $request->subject_id);
        return Leason::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'year_id' => $request->year_id,
            'semester_id' => $semesterId,
            'subject_id' => $subjectId,
            'code' => "YEAR_SEMESTER_SUBJECT-$semesterId-". $subjectId-1,
        ]);
    }
}
