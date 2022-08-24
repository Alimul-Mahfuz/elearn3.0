<?php

namespace App\Http\Middleware;

use App\Models\Authtoken;
use Closure;
use Illuminate\Http\Request;

class APIAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header("Authorization");
        if($token){
            $key = Authtoken::where('token',$token)->whereNull('expired_at')->first();

            if($key){
                return $next($request);
            }else{
                return response()->json(["msg"=>"Log in session expired"]); 
            }
            
        }else{
            return response()->json(["msg"=>"First you need to login"]);
        }
        
    }
}
