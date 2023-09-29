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
        $q = Question::with(['createdBy'])->latest();
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
        if (isset($input['search_term']) && $input['search_term']) {
            $q->whereHas(
                'lesson',
                fn ($query) =>
                $query->where('name', 'like', '%' . $input['search_term'] . '%')
            );
        }
        return $q;
    }
    public function validateOneQuestion($inputs)
    {
        return Validator::make($inputs->all(), [
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'correct_answer' => 'required',
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:0|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'lesson_id' => 'required|uuid|exists:lessons,id',
        ]);
    }

    public function createOneQuestion($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);
        $sortOrder = $this->getLatest($inputs);

        $image = $inputs->file("image_path");
        $fileName = "question_" . $subjectCode . "_" . $inputs->lesson_id . '_' . ++$sortOrder . "." . $image->getClientOriginalExtension();
        $filePath = "question/" . $fileName;
        Storage::disk("public")->put($filePath, File::get($image));

        return Question::create([
            'subject_code' => $subjectCode,
            'lesson_id' => $inputs->lesson_id,
            'sort_order' => $sortOrder,
            'correct_answer' => $inputs->correct_answer,
            'image_path' => $filePath,
            'created_by' => auth('api_admin')->user()->id,
        ]);
    }


    public function getLatest($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);

        $lastQuestion = Question::where('subject_code', $subjectCode)->where('lesson_id', $inputs->lesson_id)->orderBy('sort_order', 'desc')->first();
        return $lastQuestion ? $lastQuestion->sort_order : 0;
    }

    public function validateBatchQuestions($inputs)
    {
        return Validator::make($inputs->all(), [
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:0|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'lesson_id' => 'required|uuid|exists:lessons,id',
            'questions.*.src' => 'required|url',
            'questions.*.answer' => 'required|string|size:1',
            'questions.*.sort_order' => 'required|numeric'
        ]);
    }

    public function createBatchQuestions($inputs, $request)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($request->year, $request->semester, $request->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $request->subject);

        return Question::create([
            'subject_code' => $subjectCode,
            'lesson_id' => $request->lesson_id,
            'correct_answer' => $inputs['answer'],
            'image_path' => $inputs['src'],
            'sort_order' => $inputs['sort_order'],
            'created_by' => auth('api_admin')->user()->id,

        ]);
    }
}
