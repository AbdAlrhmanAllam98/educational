<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\LeasonService;
use App\Models\Leason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeasonController extends Controller
{
    protected LeasonService $leasonService;

    public function __construct(LeasonService $leasonService)
    {
        $this->leasonService = $leasonService;
    }

    public function index(Request $request)
    {
        $leasons = $this->leasonService->getLeasons($request);
        foreach ($leasons as $key => $leason) {
            $leasons[$key]['questions_count'] = $leason->questions()->count();
            $allCounts = 0;
            foreach ($leason->codesHistory as $value) {
                $allCounts += $value->count;
            }
            $leasons[$key]['codes_count'] = $allCounts;
        }

        return $this->response($leasons, 'All Leasons retrieved successfully', 200);
    }

    public function show($id)
    {
        $leason = Leason::findOrFail($id);
        return $this->response($leason, 'The Leason retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validate = $this->leasonService->validateLeason($request);

        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $leason = $this->leasonService->createLeason($request);
        return $this->response($leason, 'Leason created successfully', 200);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title_en' => 'string',
            'title_ar' => 'string',
            'status' => 'boolean',
        ]);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }
        try {
            Leason::where('id', $id)->update($request->all());
            $updatedLeason = Leason::find($id);
            return $this->response($updatedLeason, 'Leason Updated successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Leason Fail to Update', 400);
        }
    }
    public function delete($id)
    {
        try {
            Leason::find($id)->delete();
            return $this->response(null, 'Leason Deleted successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Leason Fail to delete', 400);
        }
    }
}
