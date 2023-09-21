<?php

namespace App\Http\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminService
{
    public function mappingSemesterCode($yearCode, $semesterCode, $typeCode)
    {
        return "$yearCode-$semesterCode-$typeCode";
    }

    public function mappingSubjectCode($semesterCode, $subjectCode)
    {
        return "$semesterCode-$subjectCode";
    }

    public function validateCreateAdmin($inputs)
    {
        return Validator::make($inputs, [
            'user_name' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function createAdmin($inputs)
    {
        $student = Admin::create([
            'user_name' => $inputs->user_name,
            'password' => Hash::make($inputs->password),
        ]);
        return $student;
    }
}
