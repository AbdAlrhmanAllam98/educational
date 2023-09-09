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
        if (isset($input['year']) && $input['year']) {
            $q->Where('subject_code', "like", $input['year'] . '%');
        }
        if (isset($input['semester']) && $input['semester']) {
            $q->Where('subject_code', "like", '%' . $input['semester'] . '%');
        }
        if (isset($input['subject']) && $input['subject']) {
            $q->Where('subject_code', "like", '%' . $input['subject'] . '%');
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('name_ar', 'ilike', '%' . $input['search_term'] . '%');
        }
        return $q;
    }
    public function validateLeason($inputs)
    {
        return Validator::make($inputs->all(), [
            'name_en' => 'required|unique:leasons,name_en',
            'name_ar' => 'required|unique:leasons,name_ar',
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:1|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
        ]);
    }
    public function createLeason($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);
        return Leason::create([
            'name_en' => $inputs->name_en,
            'name_ar' => $inputs->name_ar,
            'subject_code' => $subjectCode,
            'created_by' => 'b5aef93f-4eab-11ee-aa41-c84bd64a9918',
        ]);
    }
}
