<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\ExerciseService;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    protected ExerciseService $exerciseService;

    public function __construct(ExerciseService $exerciseService)
    {
        $this->exerciseService = $exerciseService;
    }

    public function index(Request $request)
    {
        $exercises = $this->exerciseService->getExercises($request);
        return $this->response($exercises, 'All Exercises retrieved successfully', 200);
    }

    public function show($id)
    {
        $exercise = Exercise::findOrFail($id);
        return $this->response($exercise, 'The Exercise retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validate = $this->exerciseService->validateCreateExercise($request->all());

        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $exercise = $this->exerciseService->createExercise($request);
        return $this->response($exercise, 'Exercise created successfully', 200);
    }

    public function update(Request $request, $id)
    {
        $validate = $this->exerciseService->validateUpdateExercise($request->all());
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }
        try {
            Exercise::where('id', $id)->update($request->all());
            $updatedExercise = Exercise::find($id);
            return $this->response($updatedExercise, 'Exercise Updated successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Exercise Failed to Update', 400);
        }
    }

    public function delete($id)
    {
        try {
            Exercise::find($id)->delete();
            return $this->response(null, 'Exercise Deleted successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Exercise Failed to delete', 400);
        }
    }
}
