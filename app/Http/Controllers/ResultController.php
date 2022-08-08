<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    //
    function getStudentResult($sid){
        $result=Result::where('student_id',$sid)->get();
        return response()->json([$result],200);
    }
}
