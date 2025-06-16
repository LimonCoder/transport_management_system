<?php


namespace App\helpers;


use App\Models\OrganizationInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GlobalHelper
{

    public static function getOrganizationInfo($code = null){

        $org_code = is_null($code) ? Auth::user()->org_code : $code;

        $info = DB::table('organizations')->where('org_code','1001')->first();

        return $info;
    }

    public static function getOrganizationCode(){
        return Auth::user()->org_code;
    }

}
