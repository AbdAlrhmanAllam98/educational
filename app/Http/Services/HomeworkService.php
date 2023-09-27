<?php

namespace App\Http\Services;

use App\Models\Homework;
use App\Models\Lesson;
use Illuminate\Support\Facades\Validator;


class HomeworkService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getHomeworks($input)
    {
        $q = Homework::with(['createdBy'])->latest();
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
        if (isset($input['lesson_id']) && $input['lesson_id']) {
            $q->Where('lesson_id', $input['lesson_id']);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('homework_name', 'like', '%' . $input['search_term'] . '%');
        }
        return $q;
    }
    public function validateCreateHomework($inputs)
    {
        return Validator::make($inputs, [
            'homework_name' => 'required|string',
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:0|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'lesson_id' => 'required|uuid|exists:lessons,id',
        ]);
    }

    public function validateSubmitHomework($inputs)
    {
        return Validator::make($inputs->all(), [
            'answers' => 'required|array',
            'answers.*' => 'required|string',
            'homework_id' => 'required|uuid|exists:homework,id',
        ]);
    }

    public function createHomework($inputs)
    {
        $lesson = Lesson::findOrFail($inputs->lesson_id);
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);

        $homework = Homework::create([
            'homework_name' => $inputs->homework_name,
            'subject_code' => $subjectCode,
            'lesson_id' => $lesson->id,
            'created_by' => 'b5aef93f-4eab-11ee-aa41-c84bd64a9918'
        ]);
        return $homework;
    }

    public function validateUpdateHomework($inputs)
    {
        return Validator::make($inputs, [
            'homework_name' => 'string',
        ]);
    }
}
