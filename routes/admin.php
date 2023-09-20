<?php

use App\Http\Controllers\ADMIN\AdminController;
use App\Http\Controllers\ADMIN\CodeController;
use App\Http\Controllers\ADMIN\ExamController;
use App\Http\Controllers\ADMIN\HomeworkController;
use App\Http\Controllers\ADMIN\LessonController;
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

//    api/v1/admin/

Route::post('/register', [AdminController::class, 'register']);
Route::post('/login', [AdminController::class, 'login']);


Route::group(['prefix' => 'lessons'], function () {
    Route::get('/', [LessonController::class, 'index']);
    Route::get('/{id}', [LessonController::class, 'show']);
    Route::post('/', [LessonController::class, 'store']);
    Route::post('/video', [LessonController::class, 'uploadVideo']);
    Route::put('/{id}', [LessonController::class, 'update']);
    Route::delete('/{id}', [LessonController::class, 'delete']);
});

Route::group(['prefix' => 'questions'], function () {
    Route::get('/', [QuestionController::class, 'index']);
    Route::post('/latest', [QuestionController::class, 'getLatest']);
    Route::get('/{id}', [QuestionController::class, 'show']);
    Route::post('/', [QuestionController::class, 'storeOne']);
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
Route::group(['prefix' => 'exams'], function () {
    Route::get('/', [ExamController::class, 'index']);
    Route::post('/', [ExamController::class, 'store']);
    Route::post('/select-questions', [ExamController::class, 'selectQuestion']);
    Route::get('/{id}', [ExamController::class, 'show']);
    Route::put('/{id}', [ExamController::class, 'update']);
    Route::delete('/{id}', [ExamController::class, 'delete']);
});
Route::group(['prefix' => 'homework'], function () {
    Route::get('/', [HomeworkController::class, 'index']);
    Route::post('/', [HomeworkController::class, 'store']);
    Route::post('/select-questions', [HomeworkController::class, 'selectQuestion']);
    Route::get('/{id}', [HomeworkController::class, 'show']);
    Route::put('/{id}', [HomeworkController::class, 'update']);
    Route::delete('/{id}', [HomeworkController::class, 'delete']);
});


Route::post('/questions/store', [QuestionController::class, 'storeBatch']);
