<?php

namespace App\Http\Middleware;

use App\Models\OrganizationInfo;
use Closure;

class ApiAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->has('org_code')) {

            $organiztion = OrganizationInfo::where('org_code',$request->org_code)->whereNull('deleted_at')->count();

            if ($organiztion > 0) {
                return $next($request);
            } else {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "org_code do not match",
                        "data" => []
                    ]
                    , 401);
            }

        } else {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "org_code is required",
                    "data" => []
                ]
                , 401);
        }


    }
}
