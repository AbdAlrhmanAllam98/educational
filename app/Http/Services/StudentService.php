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
        if (isset($input['year']) && $input['year']) {
            $q->Where('semester_code', 'like', $input['year'] . '%');
        }
        if (isset($input['semester']) && $input['semester']) {
            $q->Where('semester_code', "like", '_-' . $input['semester'] . '-_');
        }
        if (isset($input['type']) && $input['type']) {
            $q->Where('semester_code', "like", '_-_-' . $input['type']);
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
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:1|max:2',
            'type' => 'required|numeric|min:0|max:2',
        ]);
    }

    public function createStudent($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);

        $student = Student::create([
            'full_name' => $inputs->full_name,
            'email' => $inputs->email,
            'password' => Hash::make($inputs->password),
            'phone' => $inputs->phone,
            'parent_phone' => $inputs->parent_phone,
            'national_id' => $inputs->national_id,
            'semester_code' => $semesterCode,
        ]);
        return $student;
    }
}
