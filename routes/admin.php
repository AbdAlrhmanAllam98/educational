<?php

use App\Http\Controllers\ADMIN\CodeController;
use App\Http\Controllers\ADMIN\LeasonController;
use App\Http\Controllers\ADMIN\QuestionController;
use App\Http\Controllers\ADMIN\StudentController;
use App\Http\Controllers\ADMIN\SubjectController;
use App\Http\Controllers\CodeHistoryController;
use App\Models\CodeHistory;
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

Route::group(['prefix' => 'leasons'], function () {
    Route::get('/', [LeasonController::class, 'index']);
    Route::get('/{id}', [LeasonController::class, 'show']);
    Route::post('/', [LeasonController::class, 'store']);
    Route::put('/{id}', [LeasonController::class, 'update']);
    Route::delete('/{id}', [LeasonController::class, 'delete']);
});

Route::group(['prefix' => 'questions'], function () {
    Route::get('/', [QuestionController::class, 'index']);
    Route::get('/{id}', [QuestionController::class, 'show']);
    Route::post('/', [QuestionController::class, 'store']);
    Route::put('/{id}', [QuestionController::class, 'update']);
    Route::delete('/{id}', [QuestionController::class, 'delete']);
});

Route::group(['prefix' => 'code'], function () {
    Route::get('/', [CodeController::class, 'index']);
    Route::post('/', [CodeController::class, 'generateNewCodes']);
});

Route::group(['prefix' => 'students'], function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::get('/{id}', [StudentController::class, 'show']);
    Route::put('/{id}', [StudentController::class, 'update']);
    Route::delete('/{id}', [StudentController::class, 'delete']);
});
