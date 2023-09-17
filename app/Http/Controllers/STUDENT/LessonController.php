<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use App\Http\Services\LessonService;
use App\Models\Code;
use App\Models\Lesson;
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
        $lessons = Lesson::where('subject_code', 'like', "$user->semester_code-_")->paginate($request['per_page'] ?? 10);

        return $this->response($lessons, 'All Lessons for this user retrieved successfully', 200);
    }

    public function show($id)
    {
        $lesson = Lesson::findOrFail($id);
        return $this->response($lesson, 'The Lesson retrieved successfully', 200);
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
