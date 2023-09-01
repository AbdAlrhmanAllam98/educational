<?php

use App\Http\Controllers\SemesterController;
use App\Http\Controllers\STUDENT\ExamController;
use App\Http\Controllers\STUDENT\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\YearController;
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

//    api/v1/student/

Route::post('/register', [StudentController::class, 'register']);
Route::post('/login', [StudentController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/reedem', [StudentController::class, 'reedemCode']);
    Route::put('/update/{id}', [StudentController::class, 'update']);
    Route::put('/logout', [StudentController::class, 'logout']);

    Route::group(['prefix' => 'exams'], function () {
        Route::get('/', [ExamController::class, 'studentExams']);
        Route::get('/{id}', [ExamController::class, 'joinExam']);
        Route::post('/submit', [ExamController::class, 'submitExam']);
        Route::get('/student/answers', [ExamController::class, 'showExamAnswer']);
    });
});
