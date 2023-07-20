<?php

use App\Http\Controllers\LeasonController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//    api/v1/admin/
Route::group(['prefix' => 'subjects'], function () {
    Route::get('/',[SubjectController::class,'index']);
    Route::get('/{id}',[SubjectController::class,'show']);
});

Route::group(['prefix' => 'leasons'], function () {
    Route::get('/', [LeasonController::class, 'index']);
    Route::get('/{id}', [LeasonController::class, 'show']);
    Route::post('/', [LeasonController::class, 'store']);
    Route::put('/{id}', [LeasonController::class, 'update']);
    Route::delete('/{id}', [LeasonController::class, 'delete']);
});
