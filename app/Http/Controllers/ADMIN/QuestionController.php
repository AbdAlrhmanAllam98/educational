<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\QuestionService;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index(Request $request)
    {
        $questions = $this->questionService->getQuestions($request);
        return $this->response($questions, 'All Questions retrieved successfully', 200);
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);
        return $this->response($question, 'The Question retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validate = $this->questionService->validateQuestion($request);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, Please try again..', 422);
        }
        $leason = $this->questionService->createQuestion($request);
        return $this->response($leason, 'Question created successfully', 200);
    }

    public function update(Request $request, $id)
    {
        try {
            Question::where('id', $id)->update($request->all());
            $updatedQuestion = Question::find($id);
            return $this->response($updatedQuestion, 'Question Updated successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Question Failed to Update', 400);
        }
    }

    public function delete($id)
    {
        try {
            Question::find($id)->delete();
            return $this->response(null, 'Question Deleted successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Question Failed to Delete', 400);
        }
    }
}
