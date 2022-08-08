<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\EnrollController;
use \App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/registration/student/',[AuthController::class,'studentRegister']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/student/enroll/list/{id}',[EnrollController::class,'printEnrollments']);
Route::get('/course/student/list/{csid}',[CourseController::class,'printCoursStudnetList']);
Route::get('/course/all/',[CourseController::class,'printAllCourse']);
Route::get('/student/course/result/{sid}',[\App\Http\Controllers\ResultController::class,'getStudentResult']);
Route::get('/drop/course/{enrid}',[\App\Http\Controllers\CourseController::class,'dropCourse']);
