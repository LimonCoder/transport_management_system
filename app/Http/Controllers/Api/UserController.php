<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public $successStatus = 200;

    public function login(Request $request)
    {

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();

            $data = $this->list_data($user->org_code, $user->employee_id);

            if ($user->type != 1) {


                return response()->json(
                    [
                        "status" => "success",
                        "message" => "Admin login successfully.",
                        "data" => $data
                    ], $this->successStatus);
            } else {
                return response()->json(
                    [
                        "status" => "success",
                        "message" => "Super Admin is not allowed to login.",
                        "data" => []
                    ], 401);
            }


        } else {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Username or password is invalid",
                    "data" => []
                ]
                , 401);
        }
    }

    public function list_data($org_code,$employee_id)
    {
        $data = DB::table('organization_info AS ORG')
            ->Join('employees AS EMP', function ($join) use ($org_code,$employee_id) {
                $join->on('EMP.org_code', '=', 'ORG.org_code')
                    ->where('EMP.org_code', $org_code)
                    ->where('EMP.id', $employee_id)
                    ->whereNull('EMP.deleted_at')
                    ->whereNull('ORG.deleted_at');
            })
            ->Join('designation AS DES', function ($join){
                $join->on('EMP.designation_id', '=', 'DES.id')
                    ->whereNull('EMP.deleted_at')
                    ->whereNull('DES.deleted_at');
            })
            ->Join('users AS USG', function ($join)  use ($org_code,$employee_id) {
                $join->on('ORG.org_code', '=', 'USG.org_code')
                    ->on('USG.employee_id', '=', 'EMP.id')
                    ->where('USG.org_code', $org_code)
                    ->where('USG.employee_id', $employee_id)
                    ->whereNull('ORG.deleted_at')
                    ->whereNull('USG.deleted_at');
            })
            ->select( 'ORG.name AS org_name', 'ORG.org_code', 'ORG.address AS org_address', 'ORG.org_type',
                'EMP.id AS employee_id', 'EMP.name AS employee_name', 'EMP.mobile_no', 'DES.name AS designation', 'USG.username', 'USG.id AS user_id','USG.type')
            ->where('ORG.org_code',$org_code)
            ->where('EMP.id',$employee_id)
            ->whereNull('ORG.deleted_at')
            ->first();

        return $data;
    }
}
