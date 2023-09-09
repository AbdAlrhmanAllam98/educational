<?php

namespace App\Http\Services;

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
}
