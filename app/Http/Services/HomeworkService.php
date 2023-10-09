<?php

namespace App\Http\Services;

use App\Models\Homework;
use App\Models\HomeworkAnswers;
use Illuminate\Support\Facades\Validator;


class HomeworkService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function validateSubmitHomework($inputs)
    {
        return Validator::make($inputs->all(), [
            'answers' => 'required|array',
            'answers.*' => 'required|string',
            'homework_id' => 'required|uuid|exists:homework,id',
        ]);
    }

    public function createHomework($inputs, $lessonId)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);

        $homework = Homework::create([
            'homework_name' => $inputs->name,
            'subject_code' => $subjectCode,
            'lesson_id' => $lessonId,
            'created_by' => auth('api_admin')->user()->id,
        ]);
        return $homework;
    }

    public function selectQuestion($inputs, $homework_id)
    {
        $homeWorkQuestions = Homework::findOrFail($homework_id)->questions();
        $homeWorkQuestions->sync($inputs->questions);
        $homework = Homework::find($homework_id);
        $homework->update(['question_count' => count($inputs->questions)]);
        return $homework;
    }

    public function showHomeworkAnswers($homework_id, $student_id)
    {
        $homeworkAnswers = HomeworkAnswers::where([
            ["homework_id", $homework_id], ["student_id", $student_id]
        ])->first();
        $homework = Homework::findOrFail($homework_id);
        $homeworkAnswers = json_decode($homeworkAnswers->answer, 200);
        foreach ($homework->questions as $key => $question) {
            $homework->questions[$key]['answer'] = $question['correct_answer'];
            foreach ($homeworkAnswers as $questionId => $value) {
                if ($question->id === $questionId) {
                    $homework->questions[$key]['student_answer'] = $value;
                }
            }
        }
        return $homework;
    }
}
