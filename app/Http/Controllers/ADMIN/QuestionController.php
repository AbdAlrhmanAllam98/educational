<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminService;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    protected AdminService $questionService;

    public function __construct(AdminService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        $questions = Question::all();
        return $this->response($questions, 'All Questions retrived successfully', 200);
    }
    public function show($id)
    {
        $Question = Question::findOrFail($id);
        return $this->response($Question, 'The Question retrived successfully', 200);
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required',
            'year_id' => 'required|numeric|min:1|max:3',
            'semester_id' => 'required|numeric|min:1|max:2',
            'subject_id' => 'required|numeric|min:1|max:5',
            'leason_id' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 400);
        }

        $semesterId = $this->questionService->mappingSemester($request->year_id, $request->semester_id);
        $subjectId = $this->questionService->mappingSubject($semesterId, $request->subject_id);

        $leason = Question::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'year_id' => $request->year_id,
            'semester_id' => $semesterId,
            'subject_id' => $subjectId,
            'leason_id' => $request->leason_id,
        ]);
        return $this->response($leason, 'Question created successfully', 201);
    }
    public function update(Request $request, $id)
    {
        $updatedQuestion = Question::where('id', $id)->update($request->all());
        return $this->response($updatedQuestion, 'Question Updated successfully', 200);
    }
    public function delete($id)
    {
        Question::find($id)->delete();
        return $this->response(null, 'Question Deleted successfully', 200);
    }
}
