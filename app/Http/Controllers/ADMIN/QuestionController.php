<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\QuestionService;
use App\Models\Question;
use Illuminate\Http\Request;
use Throwable;

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

    public function getLatest(Request $request)
    {
        try {
            $sortOrder = $this->questionService->getLatest($request);
            return $this->response(["order" => $sortOrder], 'That is the latest question order for this lesson', 200);
        } catch (Throwable $e) {
            return $this->response($e->errorInfo, 'Question Failed to retrived successfully', 400);
        }
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);
        return $this->response($question, 'The Question retrieved successfully', 200);
    }

    public function storeOne(Request $request)
    {
        $validate = $this->questionService->validateOneQuestion($request);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, Please try again..', 422);
        }
        $lesson = $this->questionService->createOneQuestion($request);
        return $this->response($lesson, 'Question created successfully', 200);
    }

    public function storeBatch(Request $request)
    {
        $lessons = [];
        $validate = $this->questionService->validateBatchQuestions($request);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, Please try again..', 422);
        }

        $questions = $request->post('questions');
        unset($request['questions']);
        foreach ($questions as $key => $inputs) {
            $lesson = $this->questionService->createBatchQuestions($inputs, $request);
            array_push($lessons, $lesson);
        }
        return $this->response($lessons, 'Questions created successfully', 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $inputs = $request->all();
            $inputs['updated_by'] = 'b5aef93f-4eab-11ee-aa41-c84bd64a9918';
            Question::where('id', $id)->update($inputs);
            $updatedQuestion = Question::findOrFail($id);
            return $this->response($updatedQuestion, 'Question Updated successfully', 200);
        } catch (Throwable $e) {
            return $this->response($e->errorInfo, 'Question Failed to Update', 400);
        }
    }

    public function delete($id)
    {
        try {
            Question::find($id)->delete();
            return $this->response(null, 'Question Deleted successfully', 200);
        } catch (Throwable $e) {
            return $this->response($e->errorInfo, 'Question Failed to Delete', 400);
        }
    }
}
