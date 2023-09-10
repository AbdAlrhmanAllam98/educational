<?php

namespace App\Http\Services;

use App\Models\Exam;
use DateTime;
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
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:1|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'exam_date_start' => 'required|date',
        ]);
    }

    public function validateSubmitExam($inputs)
    {
        return Validator::make($inputs, [
            'answers' => 'required|array',
            'answers.*' => 'required|string',
            'exam_id' => 'required|uuid|exists:exams,id',
        ]);
    }

    public function createExam($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);

        $exam = Exam::create([
            'exam_name' => $inputs->exam_name,
            'full_mark' => $inputs->full_mark,
            'subject_code' => $subjectCode,
            'exam_date_start' => date($inputs->exam_date_start),
            'exam_date_end' =>  date('Y-m-d H:i:s', strtotime(date($inputs->exam_date_start) . ' + 2 hours')),
            'created_by' => 'b5aef93f-4eab-11ee-aa41-c84bd64a9918',
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
