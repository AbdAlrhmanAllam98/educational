<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\LessonService;
use App\Models\Code;
use App\Models\Lesson;
use App\Models\StudentHomeworkAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class LessonController extends Controller
{
    protected LessonService $leasonService;

    public function __construct(LessonService $leasonService)
    {
        $this->middleware('auth:api');
        $this->leasonService = $leasonService;
    }

    public function index(Request $request)
    {
        $student = auth()->user();

        $lessons = $this->leasonService->getStudentLessons($request, $student);

        $codes = Code::where('student_id', $student->id)->get()->makeHidden(['student']);

        foreach ($lessons as $lessonKey => $lessonValue) {
            $lessons[$lessonKey]['code_status'] = NULL;
            foreach ($codes as $codeKey => $codeValue) {
                if ($codeValue->status === 'Activated' && $codeValue->deactive_at <= Carbon::now(Config::get('app.timezone'))) {
                    $codeValue->update(['status' => 'Deactivated']);
                    $codes[$codeKey]['status'] = 'Deactivated';
                }
                if ($lessonValue->id === $codeValue->codeHistory->lesson_id) {
                    $lessons[$lessonKey]['code_status'] = "subscribed";
                    break;
                }
            }
            $lessons[$lessonKey]['homework_status'] = NULL;
            if (StudentHomeworkAnswer::find($lessonValue->homework?->id)) {
                $lessons[$lessonKey]['homework_status'] = "solved";
            }
        }

        return $this->response($lessons->makeHidden('homework'), 'All Lessons for this user retrieved successfully', 200);
    }

    public function show($id)
    {
        $student = auth()->user();
        $lesson = Lesson::with(['homework'])->findOrFail($id);
        $codes = Code::where('student_id', $student->id)->get();

        foreach ($codes as $codeIndex => $codeValue) {
            if ($codeValue->status === 'Activated' && $codeValue->deactive_at <= Carbon::now(Config::get('app.timezone'))) {
                $codeValue->update(['status' => 'Deactivated']);
                $codes[$codeIndex]['status'] = 'Deactivated';
            }
            if ($codeValue->codeHistory->lesson_id === $lesson->id) {
                if (($lesson->from >= Carbon::now(Config::get('app.timezone')) || Carbon::now(Config::get('app.timezone')) >= $lesson->to) && $codeValue->status !== 'Activated') {
                    $lesson->video_path = 'code_deactived';
                }
                $lesson['homework_status'] = NULL;
                if ($homeworkAnswers = StudentHomeworkAnswer::find($lesson->homework?->id)) {
                    $lesson['homework_status'] = "solved";
                    $homeworkAnswers = json_decode($homeworkAnswers->answer, 200);
                    foreach ($lesson->homework->questions as $questionKey => $questionValue) {
                        $lesson->homework->questions[$questionKey]['answer'] = $questionValue['correct_answer'];
                        foreach ($homeworkAnswers as $questionId => $value) {
                            if ($questionValue->id === $questionId) {
                                $lesson->homework->questions[$questionKey]['student_answer'] = $value;
                            }
                        }
                    };
                }
                return $this->response($lesson, 'The Lesson retrieved successfully', 200);
            }
        }
        return $this->response(null, 'This student not authorized to show lesson', 403);
    }

    public function indexByCode(Request $request)
    {
        $student = auth()->user();
        $codes = Code::where('student_id', $student->id)->get()->makeHidden(['codeHistory', 'student', 'student_id', 'created_at', 'updated_at']);
        $lessonsWithCode = [];
        foreach ($codes as $codeIndex => $codeValue) {
            if ($codeValue->status === 'Activated' && $codeValue->deactive_at <= Carbon::now(Config::get('app.timezone'))) {
                $codeValue->update(['status' => 'Deactivated']);
                $codes[$codeIndex]['status'] = 'Deactivated';
            }
            array_push($lessonsWithCode, ["code" => $codeValue, "lesson" => Lesson::select('id', 'name')->findOrFail($codeValue->codeHistory->lesson_id)]);
        }

        return $this->response($lessonsWithCode, 'Lessons for this user retrieved successfully', 200);
    }
}
