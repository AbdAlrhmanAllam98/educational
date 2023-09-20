<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\LessonService;
use App\Models\Code;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $lessons = Lesson::where('status', 1)->where('subject_code', 'like', "$user->semester_code-_")->select(['id', 'name', 'subject_code'])->paginate($request['per_page'] ?? 10);

        return $this->response($lessons, 'All Lessons for this user retrieved successfully', 200);
    }

    public function show($id)
    {
        $user = auth()->user();
        $lesson = Lesson::with(['homework'])->findOrFail($id);
        $codes = Code::where('student_id', $user->id)->get();

        foreach ($codes as $codeIndex => $codeValue) {
            if ($codeValue->codeHistory->lesson_id === $lesson->id) {
                if ($lesson->from >= Carbon::now() && Carbon::now() >= $lesson->to) {
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
        $codes = Code::where('student_id', $user->id)->get();
        $lessons = [];
        foreach ($codes as $codeIndex => $codeValue) {
            array_push($lessons, Lesson::findOrFail($codeValue->codeHistory->lesson_id));
        }

        return $this->response($lessons, 'Lessons for this user retrieved successfully', 200);
    }
}
