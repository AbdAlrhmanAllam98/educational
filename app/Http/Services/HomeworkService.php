<?php

namespace App\Http\Services;

use App\Models\Homework;
use App\Models\Leason;
use Illuminate\Support\Facades\Validator;


class HomeworkService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getHomeworks($input)
    {
        $q = Homework::latest();
        $query = $this->search($q, $input);

        return $this->search($query, $input)->paginate($input['per_page'] ?? 10);
    }

    public function search($q, $input)
    {
        $semesterId = null;
        if (isset($input['year_id']) && $input['year_id']) {
            $q->Where('year_id', $input->year_id);
        }
        if (isset($input['semester_id']) && $input['semester_id']) {
            $semesterId = $this->adminService->mappingSemester($input->year_id, $input->semester_id);
            $q->Where('semester_id', $semesterId);
        }
        if (isset($input['subject_id']) && $input['subject_id']) {
            $subjectId = $this->adminService->mappingSubject($semesterId, $input->subject_id);
            $q->Where('subject_id', $subjectId);
        }
        if (isset($input['leason_id']) && $input['leason_id']) {
            $q->Where('leason_id', $input['leason_id']);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('homework_name', 'ilike', '%' . $input['search_term'] . '%');
        }
        return $q;
    }
    public function validateCreateHomework($inputs)
    {
        return Validator::make($inputs, [
            'homework_name' => 'required|string',
            'full_mark' => 'required|numeric',
            'leason_id' => 'required|exists:leasons,id',
        ]);
    }
    public function createHomework($inputs)
    {
        $leason = Leason::find($inputs->leason_id);

        $homework = Homework::create([
            'homework_name' => $inputs->homework_name,
            'full_mark' => $inputs->full_mark,
            'year_id' => $leason->year_id,
            'semester_id' => $leason->semester_id,
            'subject_id' => $leason->subject_id,
            'leason_id' => $leason->id,
            'created_by' => 1,
        ]);
        return $homework;
    }
    public function validateUpdateHomework($inputs){
        return Validator::make($inputs, [
            'homework_name' => 'string',
            'full_mark' => 'numeric',
        ]);
    }
}
