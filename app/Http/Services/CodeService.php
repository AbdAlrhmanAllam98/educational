<?php

namespace App\Http\Services;

use App\Models\Code;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class CodeService
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getReedemedCodes($input)
    {
        $q = Code::whereNotNull('student_id')->latest();
        $query = $this->search($q, $input);

        return $this->search($query, $input)->get();
    }

    public function getNewCodes($input)
    {
        $q = Code::whereNull('student_id')->latest();
        $query = $this->search($q, $input);

        return $this->search($query, $input)->get();
    }

    public function search($q, $input)
    {
        if (isset($input['year']) && $input['year']) {
            $q->Where('subject_code', "like", $input['year'] . '%');
        }
        if (isset($input['semester']) && $input['semester']) {
            $q->Where('subject_code', "like", '_-' . $input['semester'] . '-_-_');
        }
        if (isset($input['type']) && $input['type']) {
            $q->Where('subject_code', "like", '_-_-' . $input['type'] . '-_');
        }
        if (isset($input['subject']) && $input['subject']) {
            $q->Where('subject_code', "like", '_-_-_-' . $input['subject']);
        }
        if (isset($input['lesson_id']) && $input['lesson_id']) {
            $q->Where('lesson_id', $input->lesson_id);
        }
        if (isset($input['search_term']) && $input['search_term']) {
            $q->Where('barcode', 'like', '%' . $input['search_term'] . '%');
        }
        return $q;
    }

    public function validateGeneration($request)
    {
        $validate = Validator::make($request->all(), [
            'count' => 'required|numeric|min:1',
            'year' => 'required|numeric|min:1|max:3',
            'semester' => 'required|numeric|min:0|max:2',
            'subject' => 'required|numeric|min:1|max:10',
            'lesson_id' => 'required|uuid|exists:lessons,id',
        ]);
        return $validate;
    }
    
    public function createCodes($inputs)
    {
        $semesterCode = $this->adminService->mappingSemesterCode($inputs->year, $inputs->semester, $inputs->type);
        $subjectCode = $this->adminService->mappingSubjectCode($semesterCode, $inputs->subject);

        $codes = [];
        for ($i = 0; $i < $inputs->post('count'); $i++) {
            do {
                $barcode = random_int(100000, 9999999);
            } while (Code::where('barcode', $barcode)->first());
            $code = Code::create([
                'barcode' => $barcode,
                'status' => Code::INITIALIZE,
                'subject_code' => $subjectCode,
                'lesson_id' => $inputs->post('lesson_id'),
                'deactive_at' => Carbon::now(Config::get('app.timezone'))->addDays(7),
                'created_by' => auth('api_admin')->user()->id
            ]);
            array_push($codes, $code);
        }
        return $codes;
    }
}
