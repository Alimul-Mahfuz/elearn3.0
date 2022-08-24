<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Admin;
use App\Models\Authtoken;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\WaitingTeacher;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AdminAPIController extends Controller
{
    function dashboard()
    {
        $course = Course::all();
        $teacher = Teacher::all();
        $student = Student::all();
        $account = Account::all();
        $a = $account->count();
        $t = $teacher->count();
        $s = $student->count();
        $c = $course->count();
        return response()->json([$c, $t, $s, $a]);
    }
    function home()
    {
        return response()->json("home");
    }
    function teacherAddRequest()
    {
        return response()->json("teacherAddRequest");
    }
    // ---------------------------------Teacher---------------
    function showAllTeacher()
    {
        $teacherList = Teacher::all();
        return response()->json($teacherList);
    }

    public function deleteTeacher($id)
    {
        $teacherFind = Teacher::find($id);
        if($teacherFind)
        {
            $teacherFind->delete();
            return response()->json([
                "status" => 200,
                "message" => "Teacher deleted successfully",
            ]);
        }
        else
        {
            return response()->json([
                "status" => 404,
                "message" => "Teacher ID not found",
            ]);
        }
    }
    // -------------------------------------student-----------------
    function showAllStudent()
    {
        $studentList = Student::all();
        return response()->json($studentList);
    }

    public function deleteStudent($id)
    {
        $studentFind = Student::find($id);
        if($studentFind)
        {
            $studentFind->delete();
            return response()->json([
                "status" => 200,
                "message" => "Student deleted successfully",
            ]);
        }
        else
        {
            return response()->json([
                "status" => 404,
                "message" => "Student ID not found",
            ]);
        }
    }

    // ----------------------------------Course----------------------
    function showAllCourse()
    {
        $courseList = Course::all();
        return response()->json($courseList);
    }
    function addCourse(Request $reacive)
    {
        $valid = Validator::make($reacive->all(),
            [
                "courseName" => "required ",
                "coursePrice" => "required | regex:/^[0-9]+$/i",
                "courseType" => "required ",
                "studentCapacity" => "required ",
                "courseDuration" => "required ",

                // mod
                "des" => "required",
                "tid" => "required",
                // "courseBanner" => "required|image|mimes:jpeg,png,jpg,gif,svg",
            ],
        );

        if($valid->fails()){
            return response()->json([
                "status" => 422,
                "message" => "Validation not match",
            ]);
        }

        // $name =  $reacive->file('course_pro_pic')->getClientOriginalName();
        // $ext = $reacive->file('course_pro_pic')->getClientOriginalExtension();
        // $path = "profile_images/courses/";
        // $file_name  = time() . "_$name";
        // $reacive->file('course_pro_pic')->storeAs('public/' . $path, $file_name);

        $crs = new course();

        $crs->course_name = $reacive->courseName;
        $crs->price = $reacive->coursePrice;
        $crs->catagory = $reacive->courseType;
        $crs->student_count = $reacive->studentCapacity;
        $crs->duration = $reacive->courseDuration;

        // mod
        $crs->description = $reacive->des;
        $crs->t_id = $reacive->tid;

        // $crs->profile_image = 'storage/' . $path . $file_name;
        $crs->profile_image = '';

        $crs->save();

        return response()->json([
            "status" => 200,
            "message" => "Course added successfully",
            "data" => $crs,
            
        ]);
    }

    public function deleteCourse($id)
    {
        $courseFind = Course::find($id);
        if($courseFind)
        {
            $courseFind->delete();
            return response()->json([
                "status" => 200,
                "message" => "Course deleted successfully",
            ]);
        }
        else
        {
            return response()->json([
                "status" => 404,
                "message" => "Course ID not found",
            ]);
        }
    }

    public function findCourse($id)
    {
        $courseFind = Course::find($id);

        if($courseFind)
        {
            return response()->json([
                "status" => 200,
                "course" => $courseFind
            ]);
        }
        else
        {
            return response()->json([
                "status" => 404,
                "message" => "No Course Id Found"
            ]);
        }
    }

    public function updateCourse(Request  $reacive, $id)
    {
        
            $crs = Course::find($id);

            if($crs)
            {
                $valid = Validator::make($reacive->course,
                    [
                        "course_name" => "required",
                        "price" => "required",
                        "catagory" => "required",
                        "student_count" => "required",
                        "duration" => "required",

                        // mod
                        "description" => "required",
                        "t_id" => "required"
                        // "courseBanner" => "required|image|mimes:jpeg,png,jpg,gif,svg",
                    ],
                );

                if($valid->fails()){
                    return response()->json([
                        "status" => 422,
                        "message" => "Validaton not match",
                        $valid->errors(),
                    ]);
                }
                // $crs = new course();

                $crs->course_name = $reacive->course["course_name"];
                $crs->price = $reacive->course["price"];
                $crs->catagory = $reacive->course["catagory"];
                $crs->student_count = $reacive->course["student_count"];
                $crs->duration = $reacive->course["duration"];

                // mod
                $crs->description = $reacive->course["description"];
                $crs->t_id = $reacive->course["t_id"];

                // $crs->profile_image = 'storage/' . $path . $file_name;
                $crs->profile_image = '';

                $crs->save();

                return response()->json([
                    "status" => 200,
                    "message" => "Course update successfully",
                    "data" => $crs,
                    
                ]);
            }
            else
            {
                return response()->json([
                    "status" => 404,
                    "message" => "No Course Id Found"
                ]);
            }
        

        // $name =  $reacive->file('course_pro_pic')->getClientOriginalName();
        // $ext = $reacive->file('course_pro_pic')->getClientOriginalExtension();
        // $path = "profile_images/courses/";
        // $file_name  = time() . "_$name";
        // $reacive->file('course_pro_pic')->storeAs('public/' . $path, $file_name);

        
    }

    // -------------------------Login--------------------
    
    function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        }
        else 
        {
            $acct = Account::where('email', $req->email)->where('password', $req->password)->where("type", 10)->first();
            if ($acct)
            {
                // if ($acct->type == 10) 
                // {
                    // $admin = Admin::where("acc_id", $acct->acc_id)->first();
                    // return $student;
                    $tok = new Authtoken();
                    $key = Str::random(64);
                    $tok->acc_id = $acct->acc_id;
                    $tok->token = $key;
                    $tok->created_at = new DateTime();
                    $tok->save();
                    return response()->json([
                        "status" => 200,
                        "message" => "Login Successfull",
                        "token" => $key,
                        
                    ]);
                // }
            } 
            else 
            {
                return response()->json([
                    "status" => 404,
                    "message" => "Email/Password is wrong!",
                ]);
            }
        }
    }


    function waitingTeacher()
    {
        $wt = WaitingTeacher::all();
        return response()->json($wt);
    }

    function accepteTeacher(Request $req)
    {
        $teacher = new Teacher();
        $acc = new Account();
        $pass = Str::random(4); //generate a 4 digit pass

        $acc->email = $req->email;
        $acc->password = $pass;
        $acc->type = 0;
        $acc->save();

        $e = Account::where("email", $req->email)->first();

        $teacher->acc_id = $e->acc_id;
        $teacher->name = "";
        $teacher->dob = new Datetime();
        $teacher->email = $req->email;
        $teacher->phone = "";
        $teacher->address = "";
        $teacher->qualification = "";
        $teacher->profileimage = "";
        $teacher->save();

        

        return response()->json([
            "status" => 200,
            "message" => "welcome to BD Learning"
        ]);
    }

    public function rejectTeacher($id)
    {
        $teacherFind = WaitingTeacher::find($id);
        if($teacherFind)
        {
            $teacherFind->delete();
            return response()->json([
                "status" => 200,
                "message" => "Reajecting successfull",
            ]);
        }
        else
        {
            return response()->json([
                "status" => 404,
                "message" => "Teacher I'd not found",
            ]);
        }
    }
    function logout(Request $req)
    {
        $key = $req->token;
        if($key){
            $tk = Authtoken::where("token",$key)->first();
            $tk->expired_at = new Datetime();
            $tk->save();
            return response()->json([
                "status" => 200,
                "message"=>"token expired"
            ]);
        }
    }


}
