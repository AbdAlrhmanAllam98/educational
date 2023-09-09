<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminService;
use App\Http\Services\LeasonService;
use App\Models\Leason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

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

    public function uploadVideo(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'leason_id' => 'required|exists:leasons,id',
            'video' => 'required|file|mimetypes:video/mp4',
        ]);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $leason = Leason::find($request->leason_id);

        $fileName = "Video_" . $leason->subject_code . "_" . $leason->id . ".mp4";
        $filePath = 'leasons/videos/' . $fileName;
        try {
            Storage::disk('public')->put($filePath, file_get_contents($request->video));
            $leason->video_path = storage_path('app/' . $filePath);
            $leason->save();
            return $this->response($leason, 'Video Created Successfully', 200);
        } catch (\Throwable $e) {
            return $this->response($e->errorInfo, 'Video Failed to upload', 400);
        }
    }
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name_en' => 'string',
            'name_ar' => 'string',
            'status' => 'boolean',
        ]);
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }
        try {
            $inputs = $request->all();
            $inputs['updated_by'] = 'b0267585-4ebd-11ee-976c-00163cd61d8e';
            Leason::where('id', $id)->update($inputs);
            $updatedLeason = Leason::find($id);
            return $this->response($updatedLeason, 'Leason Updated successfully', 200);
        } catch (Throwable $e) {
            return $this->response($e->errorInfo, 'Leason Fail to Update', 400);
        }
    }
    public function delete($id)
    {
        try {
            Leason::find($id)->delete();
            return $this->response(null, 'Leason Deleted successfully', 200);
        } catch (Throwable $e) {
            return $this->response($e->errorInfo, 'Leason Fail to delete', 400);
        }
    }
}
