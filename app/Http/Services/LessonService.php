<?php

namespace App\Http\Services;

use App\Models\Lesson;
use Illuminate\Support\Facades\Validator;


class LessonService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getLessons($input)
    {
        $q = Lesson::with(['createdBy'])->latest();
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
        if (isset($input['lesson_type']) && $input['lesson_type']) {
            $q->Where('type', $input['lesson_type']);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('name', 'like', '%' . $input['search_term'] . '%');
        }
        return $q;
    }

    public function getStudentLessons($input, $user)
    {
        // $q = Lesson::where('status', 1)->where('subject_code', 'like', "$user->semester_code-_")->select(['id', 'name', 'subject_code']);
        $q = Lesson::where('subject_code', 'like', "$user->semester_code-_")->select(['id', 'name', 'subject_code']);
        $query = $this->searchStudentLessons($q, $input);
        return $this->searchStudentLessons($query, $input)->get();
    }

    public function searchStudentLessons($q, $input)
    {
        if (isset($input['subject']) && $input['subject']) {
            $q->Where('subject_code', "like", '_-_-_-' . $input['subject']);
        }
        if (isset($input['lesson_type']) && $input['lesson_type']) {
            $q->Where('type', $input['lesson_type']);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('name', 'like', '%' . $input['search_term'] . '%');
        }
        return $q;
    }

    public function validateLesson($inputs)
    {
        return Validator::make($inputs->all(), [
            'name' => 'required|unique:lessons,name',
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:0|max:2',
            'type' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'lesson_type' => 'required|in:lesson,revision',
        ]);
    }
    public function createLesson($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);
        return Lesson::create([
            'name' => $inputs->name,
            'subject_code' => $subjectCode,
            'type' => $inputs->lesson_type,
            'created_by' => auth('api_admin')->user()->id,
        ]);
    }
}
