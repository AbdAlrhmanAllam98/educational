<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function response($body, $message, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => $status, 'body' => $body, 'message' => $message], $status);
    }
}
