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
        $this->middleware('auth:api_admin');
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
        $this->examService->selectQuestion($request, $exam->id);

        return $this->response($exam, 'Exam created successfully', 200);
    }


    public function update(Request $request, $id)
    {
        $validate = $this->examService->validateUpdateExam($request->all());
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }
        try {
            $exam = Exam::where('id', $id)->first();
            $inputs = $request->all();
            if (isset($request['questions']) && $request['questions']) {
                $this->examService->selectQuestion($request, $exam->id);
                unset($inputs['questions']);
            }
            $inputs['updated_by'] = auth('api_admin')->user()->id;
            $exam->update($inputs);
            $updatedExam = Exam::findOrFail($id);
            return $this->response($updatedExam, 'Exam Updated successfully', 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Exam Failed to Update', 400);
        }
    }

    public function delete($id)
    {
        try {
            Exam::findOrFail($id)->delete();
            return $this->response(null, 'Exam Deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Exam Failed to delete', 400);
        }
    }
}
