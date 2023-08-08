<?php

namespace App\Http\Services;

use App\Models\Exam;
use Illuminate\Support\Facades\Validator;


class ExamService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getExams($input)
    {
        $q = Exam::latest();
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
            $q->Where('exam_name', 'ilike', '%' . $input['search_term'] . '%');
        }
        return $q;
    }

    public function validateCreateExam($inputs)
    {
        return Validator::make($inputs, [
            'exam_name' => 'required|string',
            'full_mark' => 'required|numeric',
            'year_id' => 'required|numeric|min:1|max:3',
            'semester_id' => 'required|numeric|min:1|max:2',
            'subject_id' => 'required|numeric|min:1|max:5',
            'exam_date' => 'required|date',
        ]);
    }

    public function createExam($inputs)
    {
        $semesterId = $this->adminService->mappingSemester($inputs->year_id, $inputs->semester_id);
        $subjectId = $this->adminService->mappingSubject($semesterId, $inputs->subject_id);

        $exam = Exam::create([
            'exam_name' => $inputs->exam_name,
            'full_mark' => $inputs->full_mark,
            'year_id' => $inputs->year_id,
            'semester_id' => $semesterId,
            'subject_id' => $subjectId,
            'exam_date' => $inputs->exam_date,
        ]);
        return $exam;
    }

    public function validateUpdateExam($inputs)
    {
        return Validator::make($inputs, [
            'exam_name' => 'string',
            'full_mark' => 'numeric',
            'exam_date' => 'date',
            'exam_status' => 'boolean',
            'result_status' => 'boolean',
        ]);
    }
}
