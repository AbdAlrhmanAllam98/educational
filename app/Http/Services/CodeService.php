<?php

namespace App\Http\Services;

use App\Models\CodeHistory;
use Illuminate\Support\Facades\Validator;


class CodeService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getCodes($input)
    {
        $q = CodeHistory::latest();
        $query = $this->search($q, $input);

        return $this->search($query, $input)->with(['codes'])->paginate($input['per_page'] ?? 10);
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
        if (isset($input['leason_id']) && $input['leason_id']) {
            $q->Where('leason_id', $input->leason_id);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('barcode', 'ilike', '%' . $input['search_term'] . '%');
        }
        return $q;
    }
    public function validateGeneration($request)
    {
        $validate = Validator::make($request->all(), [
            'count' => 'required|numeric|min:1',
            'year_id' => 'required|unique:leasons,title_ar',
            'semester_id' => 'required|numeric|min:1|max:2',
            'subject_id' => 'required|numeric|min:1|max:5',
            'leason_id' => 'required|numeric|min:1',
        ]);
        return $validate;
    }
    public function createCodeHistory($request)
    {
        return CodeHistory::create([
            'count' => $request->post('count'),
            'year_id' => $request->post('year_id'),
            'semester_id' => $request->post('semester_id'),
            'subject_id' => $request->post('subject_id'),
            'leason_id' => $request->post('leason_id'),
            'admin_id' => 1,
        ]);
    }
}
