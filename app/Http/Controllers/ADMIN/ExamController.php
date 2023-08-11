<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\ExamService;
use App\Models\Exam;
use Illuminate\Http\Request;


class ExamController extends Controller
{
    protected ExamService $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index(Request $request)
    {
        $exams = $this->examService->getExams($request);
        return $this->response($exams, 'All Exams retrieved successfully', 200);
    }

    public function show($id)
    {
        $exam = Exam::findOrFail($id);
        return $this->response($exam, 'The Exam retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validate = $this->examService->validateCreateExam($request->all());

        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $exam = $this->examService->createExam($request);
        return $this->response($exam, 'Exam created successfully', 200);
    }

    public function selectQuestion(Request $request)
    {
        $examQuestions = Exam::findOrFail($request->exam_id)->questions();
        if ($examQuestions->sync($request->questions)) {
            $exam = Exam::findOrFail($request->exam_id);
            return $this->response($exam, "Questions Added To Exam", 200);
        } else {
            return $this->response(null, "Something went wrong", 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = $this->examService->validateUpdateExam($request->all());
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }
        try {
            Exam::where('id', $id)->update($request->all());
            $updatedExam = Exam::find($id);
            return $this->response($updatedExam, 'Exam Updated successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Exam Failed to Update', 400);
        }
    }

    public function delete($id)
    {
        try {
            Exam::find($id)->delete();
            return $this->response(null, 'Exam Deleted successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Exam Failed to delete', 400);
        }
    }
}
