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
    public function validateOneQuestion($inputs)
    {
        return Validator::make($inputs->all(), [
            'name_en' => 'required',
            'name_ar' => 'required',
            // 'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'correct_answer' => 'required',
            'year_id' => 'required|numeric|min:1|max:3',
            'semester_id' => 'required|numeric|min:1|max:2',
            'subject_id' => 'required|numeric|min:1|max:5',
            'leason_id' => 'required|numeric',
        ]);
    }
    public function createOneQuestion($inputs)
    {
        $semesterId = $this->adminService->mappingSemester($inputs->year_id, $inputs->semester_id);
        $subjectId = $this->adminService->mappingSubject($semesterId, $inputs->subject_id);

        $image = $inputs->file("image_path");
        $fileName = "question_" . $inputs->year_id . "_" . $semesterId . "_" . $subjectId . "_" . $inputs->leason_id . "." . $image->getClientOriginalExtension();
        $filePath = "question/" . $fileName;
        Storage::disk("public")->put($filePath, File::get($image));

        return Question::create([
            'name_en' => $inputs->name_en,
            'name_ar' => $inputs->name_ar,
            'year_id' => $inputs->year_id,
            'semester_id' => $semesterId,
            'subject_id' => $subjectId,
            'leason_id' => $inputs->leason_id,
            'correct_answer' => $inputs->correct_answer,
            'image_path' => $filePath,
            'code' => "YEAR_SEMESTER_SUBJECT-$semesterId-" . $subjectId - 1,
            'created_by' => 'b5aef93f-4eab-11ee-aa41-c84bd64a9918'
        ]);
    }
    public function validateBatchQuestions($inputs)
    {
        return Validator::make($inputs->all(), [
            'name_en' => 'required',
            'name_ar' => 'required',
            'image_path' => 'required|string',
            'correct_answer' => 'required',
            'year_id' => 'required|numeric|min:1|max:3',
            'semester_id' => 'required|numeric|min:1|max:2',
            'subject_id' => 'required|numeric|min:1|max:5',
            'leason_id' => 'required|numeric',
        ]);
    }
    public function createBatchQuestions($inputs)
    {
        $semesterId = $this->adminService->mappingSemester($inputs->year_id, $inputs->semester_id);
        $subjectId = $this->adminService->mappingSubject($semesterId, $inputs->subject_id);

        return Question::create([
            'name_en' => $inputs->name_en,
            'name_ar' => $inputs->name_ar,
            'year_id' => $inputs->year_id,
            'semester_id' => $semesterId,
            'subject_id' => $subjectId,
            'leason_id' => $inputs->leason_id,
            'correct_answer' => $inputs->correct_answer,
            'image_path' => $inputs->image_path,
            'code' => "YEAR_SEMESTER_SUBJECT-$semesterId-" . $subjectId - 1,
        ]);
    }
}
