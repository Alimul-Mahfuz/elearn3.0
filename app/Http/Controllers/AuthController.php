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
        $validator = Validator::make($req->all(), [
            "email" => "required|email",
            "firstname" => "required",
            "lastname" => "required",
            "dob" => "required",
            "phone" => "required",
            "edulevel" => "required",
            "password" => "required",
            "cnfpass" => "required|same:password"



        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $acct = new Account();
            $acct->email = $req->email;
            $acct->password = $req->password;
            $acct->type = 3;
            $acct->save();
            $student = new Student();
            $student->name = $req->firstname . ' ' . $req->lastname;
            $student->acc_id = $acct->acc_id;
            $student->email = $req->email;
            $student->dob = $req->dob;
            $student->edulevel = $req->edulevel;
            $student->phone = $req->phone;
            $student->save();
            $tok = new Authtoken();
            $key = Str::random(64);
            $tok->acc_id = $acct->acc_id;
            $tok->token = $key;
            $tok->created_at = new Datetime();
            if($tok->save()){
                return response()->json(["token" => $key, "type" => $acct->type,"stdid"=>$student->student_id,"stdname"=>$student->name], 200);
            }
            else{
                return response()->json(['msg'=>'Something went wrong'],403);
            }

        }
    }

    // Login
    function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $acct = Account::where('email', $req->email)->where('password', $req->password)->first();
            if (!empty($acct)) {
                if ($acct->type == 3) {
                    $student = Student::where("acc_id", $acct->acc_id)->first();
                    // return $student;
                    $tok = new Authtoken();
                    $key = Str::random(64);
                    $tok->acc_id = $acct->acc_id;
                    $tok->token = $key;
                    $tok->created_at = new Datetime();
                    $tok->save();
                    return response()->json(["accid" => $acct->acc_id,"type"=>$acct->type,"stdid"=>$student->student_id, "stdname"=>$student->name, "token" => $key], 200);
                }
            } else {
                return response()->json(["msg" => "Account doesn't exist"], 403);
            }
        }
    }
    //Logut 
    function logout(Request $req)
    {
        $key = $req->token;
        if($key){
            $tk = AuthToken::where("token",$key)->first();
            $tk->expired_at = new Datetime();
            $tk->save();
        }
    }
    function changepasswordstudent(Request $req, $accid)
    {
        $validator = Validator::make($req->all(), [
            "oldpassword" => "required",
            "newpassword" => "required",
            "retypednewpassword" => "required|same:newpassword"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $acct = Account::find($accid);
            if (!empty($acct) && $acct->password == $req->oldpassword) {
                $acct->password = $req->newpassword;
                $acct->save();
                return response()->json(["msg" => "password updated successfully"], 200);
            } else {
                return response()->json(["msg" => "Account doesn't exist"], 403);
            }
        }
    }
}
