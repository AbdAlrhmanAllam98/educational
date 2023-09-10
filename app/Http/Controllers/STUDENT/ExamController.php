<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\ExamService;
use App\Models\Exam;
use App\Models\ExamAnswers;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected ExamService $examService;

    public function __construct(ExamService $examService)
    {
        $this->middleware('auth:api');
        $this->examService = $examService;
    }

    public function studentExams(Request $request)
    {
        $user = auth()->user();
        $exams = Exam::where("subject_code", 'like', $user->semester_code . '%')->paginate(10);

        return $this->response($exams, 'All Exams for this user', 200);
    }

    public function joinExam(Request $request, $id)
    {
        $user = auth()->user();
        $exam = Exam::findOrFail($id);
        if (str_contains($exam->subject_code, $user->semester_code)) {
            if (date($exam->exam_date_start) <= date(now())) {
                $exam->update(['exam_status' => true]);
                return $this->response($exam, 'Joining Exam and stopwatch started', 200);
            } else {
                return $this->response(null, 'Exam Not Started yet', 400);
            }
        } else {
            return $this->response(null, 'This user unauthorized to join exam', 401);
        }
    }

    public function submitExam(Request $request)
    {
        $validate = $this->examService->validateSubmitExam($request);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, Please try again..', 422);
        }

        $questionAnswers = $request->answers;  //array of objects
        $examId = $request->exam_id;

        $examAnswers = ExamAnswers::create([
            'student_id' => auth()->user()->id,
            'answer' => json_encode($questionAnswers),
            'exam_id' => $examId,
        ]);
        return $this->response($examAnswers, "Student answer on all questions", 200);
    }

    public function showExamAnswer(Request $request)
    {
        $examAnswers = ExamAnswers::where([
            ["exam_id", $request->get('exam_id')], ["student_id", auth()->user()->id]
        ])->first();

        $exam = Exam::findOrFail($request->get('exam_id'));
        $examAnswers = json_decode($examAnswers->answer, 200);
        foreach ($exam->questions as $key => $question) {
            foreach ($examAnswers as $questionId => $value) {
                if ($questionId === $question->id);
                $exam->questions[$key]['student_answer'] = $value;
            }
        }
        return $this->response($exam, 'Exam answers retrived successfully', 200);
    }
}
