<?php

namespace App\Http\Services;

class AdminService
{
    public function mappingSemester($yearId, $semesterId)
    {
        if ($yearId == 2) {
            return $semesterId + 2;
        } else if ($yearId == 3) {
            return 5;
        } else {
            return $semesterId;
        }
    }
    public function mappingSubject($semesterId, $subjectId)
    {
        return ($semesterId * 5) - (5 - $subjectId);
    }
}
