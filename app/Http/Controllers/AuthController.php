<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Authtoken;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Datetime;

class AuthController extends Controller
{
    //Every authentication code will go here like teacher-login, student-login,registration
    /*and co-coordinator login, password checking and token passing also will be done here.*/


    function studentRegister(Request $req)
    {
        $validator = Validator::make($req->all(),[
            "email"=>"required|email",
            "firstname"=>"required",
            "lastname"=>"required",
            "dob"=>"required",
            "phone"=>"required",
            "edulevel"=>"required",
            "password"=>"required",
            "cnfpass"=>"required"



        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        else{
            $acct=new Account();
            $acct->email=$req->email;
            $acct->password=$req->password;
            $acct->type=3;
            $acct->save();
            $student=new Student();
            $student->name=$req->firstname.' '.$req->lastname;
            $student->acc_id=$acct->acc_id;
            $student->email=$req->email;
            $student->dob=$req->dob;
            $student->edu_level=$req->edulevel;
            $student->phone=$req->phone;
            $student->save();
            $tok=new Authtoken();
            $key = Str::random(64);
            $tok->acc_id=$acct->acc_id;
            $tok->token=$key;
            $tok->created_at = new Datetime();
            $tok->save();
            return response()->json(["token"=>$key,"type"=>$acct->type],200);
            }
        }


    function login(Request $req)
    {
        $validator = Validator::make($req->all(),[
            "email"=>"required|email",
            "password"=>"required"
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
       else{
           $acct=Account::where('email',$req->email)->where('password',$req->password)->first();
           if(!empty($acct))
           {
               $tok=new Authtoken();
               $key = Str::random(64);
               $tok->acc_id=$acct->acc_id;
               $tok->token=$key;
               $tok->created_at = new Datetime();
               $tok->save();
               return response()->json(["id"=>$acct->acc_id],200);

           }
           else{
               return response()->json(["msg"=>"Account doesn't exist"],403);
           }
       }
    }
}
