<?php

namespace App\Http\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
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
            $q->Where('full_name', 'ilike', '%' . $input['search_term'] . '%');
        }
        return $q;
    }

    public function validateCreateStudent($inputs)
    {
        return Validator::make($inputs, [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:6|confirmed',
            'phone' => ['required', 'regex:/(01)[0-9]{9}/', 'unique:students', 'size:11'],
            'parent_phone' => ['required', 'regex:/(01)[0-9]{9}/', 'size:11'],
            'national_id' => ['required', 'regex:/(3)[0-9]{13}/', 'unique:students', 'size:14'],
            'year_id' => 'required|numeric|min:1|max:3',
            'semester_id' => 'required|numeric|min:1|max:2',
        ]);
    }

    public function createStudent($inputs)
    {
        $semesterId = $this->adminService->mappingSemester($inputs->year_id, $inputs->semester_id);

        $student = Student::create([
            'full_name' => $inputs->full_name,
            'email' => $inputs->email,
            'password' => Hash::make($inputs->password),
            'phone' => $inputs->phone,
            'parent_phone' => $inputs->parent_phone,
            'national_id' => $inputs->national_id,
            'year_id' => $inputs->year_id,
            'semester_id' => $semesterId,
        ]);
        return $student;
    }
}
