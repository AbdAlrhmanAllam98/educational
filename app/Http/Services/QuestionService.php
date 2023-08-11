<?php

namespace App\Http\Services;

use App\Models\Question;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class QuestionService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getQuestions($input)
    {
        $q = Question::latest();
        $query = $this->search($q, $input);

        return $this->search($query, $input)->paginate($input['per_page'] ?? 10);
    }

    public function search($q, $input)
    {
        $semesterId = null;
        if (isset($input['year_id']) && $input['year_id']) {
            $q->Where('year_id', $input->year_id);
        }
        if (isset($input['semester_id']) && $input['semester_id']) {
            $semesterId = $this->adminService->mappingSemester($input->year_id, $input->semester_id);
            $q->Where('semester_id', $semesterId);
        }
        if (isset($input['subject_id']) && $input['subject_id']) {
            $subjectId = $this->adminService->mappingSubject($semesterId, $input->subject_id);
            $q->Where('subject_id', $subjectId);
        }
        if (isset($input['leason_id']) && $input['leason_id']) {
            $q->Where('leason_id', $input->leason_id);
        }
        return $q;
    }
    public function validateQuestion($request)
    {
        return Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required',
            // 'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'correct_answer' => 'required',
            'year_id' => 'required|numeric|min:1|max:3',
            'semester_id' => 'required|numeric|min:1|max:2',
            'subject_id' => 'required|numeric|min:1|max:5',
            'leason_id' => 'required|numeric',
        ]);
    }
    public function createQuestion($request)
    {
        $semesterId = $this->adminService->mappingSemester($request->year_id, $request->semester_id);
        $subjectId = $this->adminService->mappingSubject($semesterId, $request->subject_id);

        $image = $request->file("image_path");
        $fileName = "question_" . $request->year_id . "_" . $semesterId . "_" . $subjectId . "_" . $request->leason_id . "." . $image->getClientOriginalExtension();
        $filePath = "question/" . $fileName;
        Storage::disk("public")->put($filePath, File::get($image));

        return Question::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'year_id' => $request->year_id,
            'semester_id' => $semesterId,
            'subject_id' => $subjectId,
            'leason_id' => $request->leason_id,
            'correct_answer' => $request->correct_answer,
            'image_path' => $filePath,
        ]);
    }
}
