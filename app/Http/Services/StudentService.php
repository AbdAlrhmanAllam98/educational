<?php

namespace App\Http\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Validator;


class StudentService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getStudents($input)
    {
        $q = Student::latest();
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
        if (isset($input['status']) && $input['status']) {
            $q->where('status', $input['status']);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('full_name', 'like', '%' . $input['search_term'] . '%');
        }
        return $q;
    }
}
