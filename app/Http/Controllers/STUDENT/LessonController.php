<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\LessonService;
use App\Models\Code;
use App\Models\Lesson;
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
        $user = auth()->user();
        $lessons = $this->leasonService->getStudentLessons($request, $user);

        return $this->response($lessons, 'All Lessons for this user retrieved successfully', 200);
    }

    public function show($id)
    {
        $user = auth()->user();
        $lesson = Lesson::with(['homework'])->findOrFail($id);
        $codes = Code::where('student_id', $user->id)->get();

        foreach ($codes as $codeIndex => $codeValue) {
            if ($codeValue->codeHistory->lesson_id === $lesson->id) {
                if ($lesson->from >= Carbon::now(Config::get('app.timezone')) && Carbon::now(Config::get('app.timezone')) >= $lesson->to) {
                    $lesson->video_path = null;
                }
                return $this->response($lesson, 'The Lesson retrieved successfully', 200);
            }
        }
        return $this->response(null, 'This student not authorized to show lesson', 403);
    }

    public function indexByCode(Request $request)
    {
        $user = auth()->user();
        $codes = Code::where('student_id', $user->id)->select('id','barcode','code_id')->get()->makeHidden(['codeHistory','student']);
        $lessons = [];
        foreach ($codes as $codeIndex => $codeValue) {
            array_push($lessons, ["code" => $codeValue, "lesson" => Lesson::select('id','name')->findOrFail($codeValue->codeHistory->lesson_id)]);
        }

        return $this->response($lessons, 'Lessons for this user retrieved successfully', 200);
    }
}
