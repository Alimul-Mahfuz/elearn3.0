<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enroll;
use App\Models\Studentpayment;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    //
    // let sid = useParams()
    
    function studentpayment(Request $req,$sid,$csid){
        $validator = Validator::make($req->all(), [
            "cardno" => "required|max:11",
            "cvc" => "required",

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        else{
            $price=Course::find($csid);
            $payment=new Studentpayment();
            $payment->card_no=$req->cardno;
            $payment->cvc=$req->cvc;
            $payment->amount=$price->price;
            $payment->student_id=$sid;
            $payment->course_id=$csid;
            $payment->save();
            $enroll=new Enroll();
            $enroll->course_id=$csid;
            $enroll->student_id=$sid;
            $enroll->paymentid=$payment->paymentid;
            $enroll->date=new DateTime();
            if($enroll->save()){
                return response()->json(['msg'=>"Enrolled"],200);
            }
            else{
                return response()->json(['msg'=>"Something went wrong"],502);
            }
            
        }
    }

}
