<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\EnrollController;
use \App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;

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

//APIs
//Get request via post method.



/*Received all necessary parameter to create a student account type 3 and also
insert new student into students table. If successfully the user get 64 character long token along with account_type and
student_id. account_id and token generation time, will be inserted into auth-tokens table*/
Route::post('/registration/student/',[AuthController::class,'studentRegister']);

/*Receives user's email and password validate and if successfully then a token along with student_id or teacher_id
and account's type will be returned as response*/
Route::post('/login',[AuthController::class,'login']);

/*Received any request from request token header and find the token on token database.then expired the token validity so that the user cannot access any logged contents*/
Route::any('/logout',[AuthController::class,'logout']);


/*Parameterized route take mandatory argument student_id and return all enrolled course's coursename,duration,
tname,tamil of that particular student in array format*/
Route::get('/student/enroll/list/{st_id}',[EnrollController::class,'printEnrollments']);


/*Parameterized route take mandatory argument course_id and return two objects. The first one contain course information.
The second object contains an array of student's information
*/
Route::get('/course/student/list/{cs_id}',[CourseController::class,'printCoursStudnetList']);


/*Return all an array of objects contains course_id, name, duration, price, status and banner's image url*/
Route::get('/course/all/',[CourseController::class,'printAllCourse']);

/*Mandatory parameter student_id and get all result of that student*/
Route::get('/student/course/result/{sid}',[\App\Http\Controllers\ResultController::class,'getStudentResult']);

//For changing password
Route::post('/change/password/{aid}',[AuthController::class,'changepasswordstudent']);
//For enrolling student after successfully payment
Route::post('/student/enroll/payment/{sid}/{csid}',[PaymentController::class,'studentpayment']);
//Delete a student if the student wish to drop the course
Route::delete('/drop/course/{enrid}',[\App\Http\Controllers\CourseController::class,'dropCourse']);
//Show details course teacher info
Route::get('/course/teacher/info/{csid}',[\App\Http\Controllers\CourseController::class,'courseteacherinfo']);

//Get student profile information
Route::get('/student/profile/{sid}',[AuthController::class,'studentprofile']);

//cv submission for teacher
Route::post('/registration/submit/cv',[AuthController::class,'submitcv']);


