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
        if (isset($input['year']) && $input['year']) {
            $q->Where('subject_code', "like", $input['year'] . '%');
        }
        if (isset($input['semester']) && $input['semester']) {
            $q->Where('subject_code', "like", '_-' . $input['semester'] . '-_-_');
        }
        if (isset($input['type']) && $input['type']) {
            $q->Where('subject_code', "like", '_-_-' . $input['type'] . '-_');
        }
        if (isset($input['subject']) && $input['subject']) {
            $q->Where('subject_code', "like", '_-_-_-' . $input['subject']);
        }
        if (isset($input['leason_id']) && $input['leason_id']) {
            $q->Where('leason_id', $input->leason_id);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('barcode', 'like', '%' . $input['search_term'] . '%');
        }
        return $q;
    }
    public function validateGeneration($request)
    {
        $validate = Validator::make($request->all(), [
            'count' => 'required|numeric|min:1',
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:1|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'leason_id' => 'required|uuid',
        ]);
        return $validate;
    }
    public function createCodeHistory($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);

        return CodeHistory::create([
            'count' => $inputs->post('count'),
            'subject_code' => $subjectCode,
            'leason_id' => $inputs->post('leason_id'),
            'created_by' => 'b5aef93f-4eab-11ee-aa41-c84bd64a9918',
            'updated_by' => 'b5aef93f-4eab-11ee-aa41-c84bd64a9918',
        ]);
    }
}
