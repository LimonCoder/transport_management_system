<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $app_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9';

        $request_app_key = $request->header('APP-KEY');



        if($request_app_key == $app_key){
            return $next($request);
        }
        else{
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Un-Athorized",
                    "data" => []
                ]
                ,401);
        }
    }
}
