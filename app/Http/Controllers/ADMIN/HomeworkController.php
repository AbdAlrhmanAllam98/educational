<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\HomeworkService;
use App\Models\Homework;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    protected HomeworkService $homeworkService;

    public function __construct(HomeworkService $homeworkService)
    {
        $this->homeworkService = $homeworkService;
    }

    public function index(Request $request)
    {
        $homeworks = $this->homeworkService->getHomeworks($request);
        return $this->response($homeworks, 'All Homeworks retrieved successfully', 200);
    }

    public function show($id)
    {
        $homework = Homework::findOrFail($id);
        return $this->response($homework, 'The Homework retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validate = $this->homeworkService->validateCreateHomework($request->all());

        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $homework = $this->homeworkService->createHomework($request);
        return $this->response($homework, 'Homework created successfully', 200);
    }
    public function selectQuestion(Request $request)
    {
        $homeWorkQuestions = Homework::findOrFail($request->homework_id)->questions();
        if ($homeWorkQuestions->sync($request->questions)) {
            $homework = Homework::findOrFail($request->homework_id);
            return $this->response($homework, "Questions Added To Homework", 200);
        } else {
            return $this->response(null, "Something went wrong", 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validate = $this->homeworkService->validateUpdateHomework($request->all());
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }
        try {
            Homework::where('id', $id)->update($request->all());
            $updatedHomework = Homework::find($id);
            return $this->response($updatedHomework, 'Homework Updated successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Homework Failed to Update', 400);
        }
    }

    public function delete($id)
    {
        try {
            Homework::find($id)->delete();
            return $this->response(null, 'Homework Deleted successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Homework Failed to delete', 400);
        }
    }
}
