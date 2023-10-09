<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminService;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{

    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
        $this->middleware('auth:api_admin', ['except' => ['login', 'register']]);
    }

    public function index(Request $request)
    {
        $admins = Admin::all();
        return $this->response($admins, 'All Admins retrieved successfully', 200);
    }

    public function login(Request $request)
    {
        $cred = ["user_name" => $request->post("user_name"), "password" => $request->post('password')];
        $token = auth('api_admin')->attempt($cred);
        if (!$token) {
            return $this->response(null, 'Unauthorized', 401);
        }

        $admin = auth('api_admin')->user();
        $expireIn = Carbon::now(Config::get('app.timezone'))->addMinutes(Auth::factory()->getTTL());
        return $this->response(['admin' => $admin, 'Authorization' => ["token" => $token, 'expires_in' => $expireIn, "type" => "Bearer"]], 'Welcome back');
    }

    public function register(Request $request)
    {
        $validate = $this->adminService->validateCreateAdmin($request->all());
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $admin = $this->adminService->createAdmin($request);

        $token = Auth::login($admin);


        return $this->response(['admin' => $admin], "Admin Created Successfully", 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $validate = $this->adminService->validateUpdateAdmin($request->all());
            if ($validate->fails()) {
                return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
            }
            Admin::where('id', $id)->update($request->all());
            $updatedQuestion = Admin::findOrFail($id);
            return $this->response($updatedQuestion, 'Admin Updated successfully', 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Admin Failed to Update', 400);
        }
    }

    public function delete($id)
    {
        try {
            Admin::destroy($id);
            return $this->response(null, 'Admin Deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 'Admin Failed to Delete', 400);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
