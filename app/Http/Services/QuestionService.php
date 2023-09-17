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
        if (isset($input['year']) && $input['year']) {
            $q->Where('subject_code', "like", $input['year'] . '%');
        }
        if (isset($input['semester']) && $input['semester']) {
            $q->Where('subject_code', "like", '_-' . $input['semester'] . '-_-_');
        }
        if (isset($input['type']) && $input['type']) {
            $q->Where('subject_code', "like", '_-_-' . $input['type'] . '-_');
        }
        if (isset($input['subject']) && $input['subject']) {
            $q->Where('subject_code', "like", '_-_-_-' . $input['subject']);
        }
        if (isset($input['leason_id']) && $input['leason_id']) {
            $q->Where('leason_id', $input->leason_id);
        }
        return $q;
    }
    public function validateOneQuestion($inputs)
    {
        return Validator::make($inputs->all(), [
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'correct_answer' => 'required',
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:1|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'leason_id' => 'required|uuid',
        ]);
    }

    public function createOneQuestion($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);

        $lastQuestion = Question::where('subject_code', $subjectCode)->where('leason_id', $inputs->leason_id)->orderBy('sort_order', 'desc')->first();
        $sortOrder = $lastQuestion ? $lastQuestion->sort_order : 0;

        $image = $inputs->file("image_path");
        $fileName = "question_" . $subjectCode . "_" . $inputs->leason_id . ++$sortOrder . "." . $image->getClientOriginalExtension();
        $filePath = "question/" . $fileName;
        Storage::disk("public")->put($filePath, File::get($image));

        return Question::create([
            'subject_code' => $subjectCode,
            'leason_id' => $inputs->leason_id,
            'sort_order' => $sortOrder,
            'correct_answer' => $inputs->correct_answer,
            'image_path' => $filePath,
            'created_by' => 'b5aef93f-4eab-11ee-aa41-c84bd64a9918',
        ]);
    }

    public function validateBatchQuestions($inputs)
    {
        return Validator::make($inputs->all(), [
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:1|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'leason_id' => 'required|uuid',
            'questions.*.src' => 'required|url',
            'questions.*.answer' => 'required|string|size:1'
        ]);
    }

    public function createBatchQuestions($inputs, $request)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($request->year, $request->semester, $request->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $request->subject);

        return Question::create([
            'subject_code' => $subjectCode,
            'leason_id' => $request->leason_id,
            'correct_answer' => $inputs['answer'],
            'image_path' => $inputs['src'],
            'created_by' => 'b5aef93f-4eab-11ee-aa41-c84bd64a9918',

        ]);
    }
}
