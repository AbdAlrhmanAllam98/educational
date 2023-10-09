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
        $student = auth()->user();
        $homeworks = Homework::where("subject_code", 'like', $student->semester_code . '%')->select('id', 'homework_name', 'lesson_id')->paginate($request['per_page'] ?? 10);

        return $this->response($homeworks, 'All Homework for this user', 200);
    }

    public function doHomework(Request $request, $id)
    {
        $student = auth()->user();
        $homework = Homework::findOrFail($id);
        if (str_contains($homework->subject_code, $student->semester_code)) {
            if (HomeworkAnswers::where('student_id', $student->id)->where('homework_id', $id)->first() != null) {
                $homeworkAnswers = $this->homeworkService->showHomeworkAnswers($homework->id, $student->id);
                $homeworkAnswers['status'] = 'submitted';
                return $this->response($homeworkAnswers, 'Homework Answers retrived successfully', 200);
            }
            $homework['status'] = 'pending';
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
        $studentId = auth()->user()->id;

        if (HomeworkAnswers::where('student_id', $studentId)->where('homework_id', $homeworkId)->first() != null) {
            return $this->response(null, 'Something went wrong', 400);
        }

        $homeworkAnswers = HomeworkAnswers::create([
            'student_id' => $studentId,
            'answer' => json_encode($questionAnswers),
            'homework_id' => $homeworkId,
        ]);
        return $this->response($homeworkAnswers, "Student answer on all questions", 200);
    }
}
