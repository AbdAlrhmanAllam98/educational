<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\HomeworkService;
use App\Models\Homework;
use App\Models\HomeworkAnswers;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    protected HomeworkService $homeworkService;

    public function __construct(HomeworkService $homeworkService)
    {
        $this->middleware('auth:api');
        $this->homeworkService = $homeworkService;
    }

    public function studentHomeworks(Request $request)
    {
        $user = auth()->user();
        $homeworks = Homework::where("subject_code", 'like', $user->semester_code . '%')->select('id', 'homework_name', 'lesson_id')->paginate($request['per_page'] ?? 10);

        return $this->response($homeworks, 'All Homework for this user', 200);
    }

    public function doHomework(Request $request, $id)
    {
        $user = auth()->user();
        $homework = Homework::findOrFail($id);
        if (str_contains($homework->subject_code, $user->semester_code)) {
            return $this->response($homework, 'Start to do Homework', 200);
        } else {
            return $this->response(null, 'This user unauthorized to do homework', 401);
        }
    }

    public function submitHomework(Request $request)
    {
        $validate = $this->homeworkService->validateSubmitHomework($request);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, Please try again..', 422);
        }

        $questionAnswers = $request->answers;  //array of objects
        $homeworkId = $request->homework_id;

        $homeworkAnswers = HomeworkAnswers::create([
            'student_id' => auth()->user()->id,
            'answer' => json_encode($questionAnswers),
            'homework_id' => $homeworkId,
        ]);
        return $this->response($homeworkAnswers, "Student answer on all questions", 200);
    }

    public function showHomeworkAnswers(Request $request)
    {
        $homeworkAnswers = HomeworkAnswers::where([
            ["homework_id", $request->get('homework_id')], ["student_id", auth()->user()->id]
        ])->first();
        $homework = Homework::findOrFail($request->get('homework_id'));
        $homeworkAnswers = json_decode($homeworkAnswers->answer, 200);
        foreach ($homework->questions as $key => $question) {
            $homework->questions[$key]['answer'] = $question['correct_answer'];
            foreach ($homeworkAnswers as $questionId => $value) {
                if ($question->id === $questionId) {
                    $homework->questions[$key]['student_answer'] = $value;
                }
            }
        }
        return $this->response($homework, 'Homework answers retrived successfully', 200);
    }
}
