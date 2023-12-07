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
                if ($codeValue->status === Code::ACTIVE && $codeValue->deactive_at <= Carbon::now(Config::get('app.timezone'))) {
                    $codeValue->update(['status' => Code::DEACTIVE]);
                    $codes[$codeKey]['status'] = Code::DEACTIVE;
                }
                if ($lessonValue->id === $codeValue->lesson_id) {
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
        $lessonCodes = Code::where('student_id', $student->id)->where('lesson_id', $lesson->id)->orderBy('activated_at', 'desc')->get();

        foreach ($lessonCodes as $codeIndex => $codeValue) {
            if ($codeValue->status === Code::ACTIVE && $codeValue->deactive_at <= Carbon::now(Config::get('app.timezone'))) {
                $codeValue->update(['status' => Code::DEACTIVE]);
                $codes[$codeIndex]['status'] = Code::DEACTIVE;
            }

            if (($lesson->from >= Carbon::now(Config::get('app.timezone')) || Carbon::now(Config::get('app.timezone')) >= $lesson->to) && $codeValue->status !== Code::ACTIVE) {
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
        return $this->response(null, 'This student not authorized to show lesson', 403);
    }

    public function indexByCode(Request $request)
    {
        $student = auth()->user();
        $codes = Code::where('student_id', $student->id)->get()->makeHidden(['student', 'student_id', 'created_at', 'updated_at']);
        $lessonsWithCode = [];
        foreach ($codes as $codeIndex => $codeValue) {
            if ($codeValue->status === Code::ACTIVE && $codeValue->deactive_at <= Carbon::now(Config::get('app.timezone'))) {
                $codeValue->update(['status' => Code::DEACTIVE]);
                $codes[$codeIndex]['status'] = Code::DEACTIVE;
            }
            array_push($lessonsWithCode, ["code" => $codeValue, "lesson" => Lesson::select('id', 'name')->findOrFail($codeValue->lesson_id)]);
        }

        return $this->response($lessonsWithCode, 'Lessons for this user retrieved successfully', 200);
    }
}
