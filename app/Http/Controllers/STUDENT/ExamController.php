<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAnswers;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function studentExams(Request $request)
    {
        $user = auth()->user();
        $exams = Exam::where("semester_id", $user->semester_id)->select(['id', 'exam_name'])->paginate(10);

        return $this->response($exams, 'All Exams for this user', 200);
    }

    public function joinExam(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);
        if ($exam->exam_status) {
            return $this->response($exam, 'Joining Exam and stopwatch started', 200);
        } else {
            return $this->response(null, 'Exam Not Started yet', 400);
        }
    }

    public function submitExam(Request $request)
    {
        $questionAnswers = $request->answers;  //array of objects
        $examId = $request->exam_id;  //array of objects

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
            foreach ($examAnswers as $value) {
                if ($value['question_id'] === $question->id);
                $exam->questions[$key]['student_answer'] = $value["answer"];
            }
        }
        return $this->response($exam, 'Exam answers retrived successfully', 200);
    }
}
