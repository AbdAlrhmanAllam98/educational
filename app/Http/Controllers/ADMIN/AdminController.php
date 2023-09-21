<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
        $this->middleware('auth:api_admin', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $cred = ["user_name" => $request->post("user_name"), "password" => $request->post('password')];
        $token = auth('api_admin')->attempt($cred);
        if (!$token) {
            return $this->response(null, 'Unauthorized', 401);
        }

        $admin = auth('api_admin')->user();
        return $this->response(['admin' => $admin, 'Authorization' => ["token" => $token, "type" => "Bearer"]], 'Welcome back');
    }

    public function register(Request $request)
    {
        $validate = $this->adminService->validateCreateAdmin($request->all());
        if ($validate->fails()) {
            return $this->response($validate->errors(), 'Something went wrong, please try again..', 422);
        }

        $admin = $this->adminService->createAdmin($request);

        $token = Auth::login($admin);


        return $this->response(['admin' => $admin, 'Authorization' => ["token" => $token, "type" => "Bearer"]], "Student Created Successfully", 200);
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
