<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enroll;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

class EnrollController extends Controller
{
    //recived studnet_id and return all enrolled course along with teacher info
    function printEnrollments($sid){
        $enroll_list=Enroll::where('student_id',$sid)->get();
        $courseinfo=array();
        foreach ($enroll_list as $enroll){
            $course=Course::find($enroll->course_id);
            $teacher=$course->teacher()->first();
            $info=[
                "cousename"=>$course->name,
                "duration"=>$course->duration,
                "tname"=>$teacher->name,
                "tmail"=>$teacher->email

            ];
            $courseinfo[] = $info;

        }
        return response()->json($courseinfo,200);
    }

    //Enroll
    function enrollCourse($sid,$cid,$pid){


    }
}
