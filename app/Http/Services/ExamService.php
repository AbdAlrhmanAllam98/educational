<?php

namespace App\Http\Services;

use App\Models\Exam;
use App\Models\ExamAnswers;
use App\Models\StudentResult;
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
        $q = Exam::with(['createdBy', 'updatedBy'])->latest();
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
            $q->Where('exam_name', 'like', '%' . $input['search_term'] . '%');
        }
        return $q;
    }

    public function validateCreateExam($inputs)
    {
        return Validator::make($inputs, [
            'exam_name' => 'required|string',
            'full_mark' => 'required|numeric',
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:0|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'exam_date_start' => 'required|date',
            'questions' => 'array',
            'questions.*' => 'uuid|exists:questions,id',
        ]);
    }

    public function selectQuestion($inputs, $examId)
    {
        $examQuestions = Exam::findOrFail($examId)->questions();
        $examQuestions->sync($inputs->questions);
        $exam = Exam::find($examId);
        $exam->update(['question_count' => count($inputs->questions)]);
        return $exam;
    }

    public function validateSubmitExam($inputs)
    {
        return Validator::make($inputs->all(), [
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
            'created_by' => auth('api_admin')->user()->id,
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
            'questions' => 'array',
            'questions.*' => 'uuid|exists:questions,id',
        ]);
    }

    public function showExamAnswer($exam_id, $student_id)
    {
        $examAnswers = ExamAnswers::where([
            ["exam_id", $exam_id], ["student_id", $student_id]
        ])->first();

        $examResult = Exam::findOrFail($exam_id);
        $examAnswers = json_decode($examAnswers->answer, 200);
        foreach ($examResult->questions as $key => $question) {
            $examResult->questions[$key]['answer'] = $question['correct_answer'];
            foreach ($examAnswers as $questionId => $value) {
                if ($question->id === $questionId) {
                    $examResult->questions[$key]['student_answer'] = $value;
                }
            }
        }
        $examResult['exam_result'] = StudentResult::where([
            ["exam_id", $exam_id], ["student_id", $student_id]
        ])->first()->result;

        return $examResult;
    }

    public function calculateExam($exam, $examAnswers)
    {
        $point = $exam->full_mark / $exam->question_count;
        $examResult = 0;
        $examAnswers = json_decode($examAnswers->answer, 200);
        foreach ($exam->questions as $key => $question) {
            foreach ($examAnswers as $questionId => $value) {
                if ($questionId === $question->id) {
                    if ($question['correct_answer'] == $value) {
                        $examResult += $point;
                    }
                    unset($examAnswers[$questionId]);
                }
            }
        }
        StudentResult::create([
            "student_id" => auth()->user()->id,
            "exam_id" => $exam->id,
            "result" => $examResult,
            "type" => "exam"
        ]);
    }
}
