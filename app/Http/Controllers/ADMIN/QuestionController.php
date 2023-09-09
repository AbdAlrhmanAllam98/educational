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
        $leason = $this->questionService->createOneQuestion($request);
        return $this->response($leason, 'Question created successfully', 200);
    }

    public function storeBatch(Request $request)
    {
        $leasons = [];
        foreach ($request->data as $key => $inputs) {
            $validate = $this->questionService->validateBatchQuestions($inputs);
            if ($validate->fails()) {
                return $this->response($validate->errors(), 'Something went wrong, Please try again..', 422);
            }

            $leason = $this->questionService->createBatchQuestions($inputs);
            array_push($leasons, $leason);
        }
        return $this->response($leasons, 'Questions created successfully', 200);
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
