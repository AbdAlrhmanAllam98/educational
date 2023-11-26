<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\ExamService;
use App\Models\Exam;
use App\Models\ExamAnswers;
use App\Models\StudentResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

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
        $student = auth()->user();
        $exams = Exam::where("subject_code", 'like', $student->semester_code . '%')->get();
        foreach ($exams as $key => $exam) {
            if ($exam->exam_date_start > Carbon::now(Config::get('app.timezone'))) {
                $exams[$key]['status'] = "pending";
            } else if ($exam->exam_date_start <= Carbon::now(Config::get('app.timezone')) && Carbon::now(Config::get('app.timezone')) <= $exam->exam_date_end) {
                $exam->update(['exam_status' => true]);
                $exams[$key]['status'] = "entered";
            } else if ($exam->exam_date_end < Carbon::now(Config::get('app.timezone'))) {
                if (!ExamAnswers::where('student_id', $student->id)->where('exam_id', $exam->id)->first()) {
                    $exams[$key]['status'] = "absent";
                } else {
                    if ($exam->result_status) {
                        $exams[$key]['status'] = "checked";
                        $exams[$key]['exam_result'] = StudentResult::where('exam_id', $exam->id)->where('student_id', $student->id)->first()->result;
                    } else {
                        $exams[$key]['status'] = "completed";
                    }
                }
            }
        }

        return $this->response($exams, 'All Exams for this user', 200);
    }

    public function studentExam(Request $request, $id)
    {
        $student = auth()->user();
        $exam = Exam::with(['questions'])->findOrFail($id);
        if (str_contains($exam->subject_code, $student->semester_code)) {
            if ($exam->exam_date_start <= Carbon::now(Config::get('app.timezone')) && Carbon::now(Config::get('app.timezone')) <= $exam->exam_date_end) {
                if (ExamAnswers::where('student_id', $student->id)->where('exam_id', $exam->id)->first()) {
                    $exam['status'] = "submitted";
                    return $this->response($exam, 'You Submit this Exam but exam result comming soon...', 200);
                }
                $exam["status"] = "entered";
                return $this->response($exam, 'Joining Exam and stopwatch started', 200);
            } else if ($exam->exam_date_end < Carbon::now(Config::get('app.timezone'))) {
                if (!ExamAnswers::where('student_id', $student->id)->where('exam_id', $exam->id)->first()) {
                    $exam['status'] = "absent";
                    return $this->response($exam->makeHidden('questions'), 'You lost to join this exam', 200);
                } else {
                    if ($exam->result_status) {
                        $examResult = $this->examService->showExamAnswer($exam->id, $student->id);
                        $examResult['status'] = "checked";
                        return $this->response($examResult, 'This is Your answers and corrected answers', 200);
                    } else {
                        $exam['status'] = "submitted";
                        return $this->response($exam, 'You Submit this Exam but exam result comming soon...', 200);
                    }
                }
            } else if ($exam->exam_date_start > Carbon::now(Config::get('app.timezone'))) {
                $exam['status'] = "pending";
                return $this->response($exam->makeHidden('questions'), 'Comming soon...', 200);
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
        $exam = Exam::with(['questions'])->findOrFail($examId);
        $userId = auth()->user()->id;

        if (ExamAnswers::where('student_id', $userId)->where('exam_id', $examId)->first() != null || $exam->exam_date_start > Carbon::now(Config::get('app.timezone')) || Carbon::now(Config::get('app.timezone')) > $exam->exam_date_end) {
            return $this->response(null, 'Something went wrong', 400);
        }

        $examAnswers = ExamAnswers::create([
            'student_id' => $userId,
            'answer' => json_encode($questionAnswers),
            'exam_id' => $examId,
        ]);

        $this->examService->calculateExam($exam, $examAnswers);
        return $this->response($examAnswers, "Student answer on all questions", 200);
    }
}
