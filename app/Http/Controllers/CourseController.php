<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enroll;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //Recived course_id and return all studnet details under the course
    function printCoursStudnetList($cs_id): \Illuminate\Http\JsonResponse
    {
        $coursestudentinfo=array();
        $enrolls=Enroll::where('course_id',$cs_id)->get();
        $courseinfo=Course::find($cs_id);
        foreach ($enrolls as $enroll){
            $student=$enroll->student()->first();
            $coursestudentinfo[] = $student;
        }
        return response()->json(["crsinfo"=>$courseinfo,"crsstdinfo"=>$coursestudentinfo],200);
    }
    //Print all the course where active status is 1 and t_id is not null
    function printAllCourse(): \Illuminate\Http\JsonResponse
    {
        $couses=Course::where('status',1)->whereNotNull('t_id')->get();
        return response()->json($couses,200);
    }

    function dropCourse($enrid){
        $enroll=Enroll::find($enrid);
        $enroll->delete();
        return response()->json(['msg'=>"Course dropped"],200);
    }

    function courseteacherinfo($csid){
        $courseinfo=Course::with('teacher')->find($csid);
        return response()->json($courseinfo,200);
    }

}
