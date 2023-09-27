<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\LessonService;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    protected LessonService $leasonService;

    public function __construct(LessonService $leasonService)
    {
        $this->leasonService = $leasonService;
        $this->middleware('auth:api_admin');
    }

    public function index(Request $request)
    {
        $lessons = $this->leasonService->getLessons($request);
        foreach ($lessons as $key => $lesson) {
            $lessons[$key]['questions_count'] = $lesson->questions()->count();
            $allCounts = 0;
            foreach ($lesson->codesHistory as $value) {
                $allCounts += $value->count;
            }
            $lessons[$key]['codes_count'] = $allCounts;
        }

        return $this->response($lessons, 'All Lessons retrieved successfully', 200);
    }

    public function show($id)
    {
        $lesson = Lesson::with(['homework'])->findOrFail($id);
        return $this->response($lesson, 'The Lesson retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validate = $this->leasonService->validateLesson($request);

        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $lesson = $this->leasonService->createLesson($request);
        return $this->response($lesson, 'Lesson created successfully', 200);
    }

    public function uploadVideo(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'lesson_id' => 'required|exists:lessons,id',
            'video' => 'required|file|mimetypes:video/mp4',
            'from' => 'required|date',
            'to' => 'required|date|after:from'
        ]);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $lesson = Lesson::findOrFail($request->lesson_id);

        $fileName = "Video_" . $lesson->subject_code . "_" . $lesson->id . ".mp4";
        $filePath = 'lessons/videos/' . $fileName;
        try {
            if (!Storage::exists("public/$filePath")) {
                Storage::disk('public')->put($filePath, file_get_contents($request->video));
                $lesson->video_path = env('APP_URL') . '' . Storage::url($filePath);
                $lesson->from = $request->from;
                $lesson->to = $request->to;
                $lesson->save();
                return $this->response($lesson, 'Video Created Successfully', 200);
            } else {
                return $this->response(null, 'One Video uploaded for lesson', 400);
            }
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Video Failed to upload', 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'string',
            'status' => 'boolean',
            'from' => 'date',
            'to' => 'date|after:from',
        ]);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }
        try {
            $inputs = $request->all();
            $inputs['updated_by'] = 'b5aef93f-4eab-11ee-aa41-c84bd64a9918';
            Lesson::where('id', $id)->update($inputs);
            $updatedLesson = Lesson::findOrFail($id);
            return $this->response($updatedLesson, 'Lesson Updated successfully', 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Lesson Fail to Update', 400);
        }
    }
    public function delete($id)
    {
        try {
            Lesson::findOrFail($id)->delete();
            return $this->response(null, 'Lesson Deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Lesson Fail to delete', 400);
        }
    }
}
