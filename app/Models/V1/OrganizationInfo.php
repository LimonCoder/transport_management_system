<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OrganizationInfo extends Model
{

    protected $table = 'organizations';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public static function list_data(){
        $data = DB::table('organization_info AS ORG')
            ->Join('employees AS EMP',function($join) {
                $join->on('EMP.org_code','=','ORG.org_code')
                    ->whereNull('EMP.deleted_at')
                    ->whereNull('ORG.deleted_at');
            })
            ->Join('users AS USG',function($join) {
                $join->on('ORG.org_code','=','USG.org_code')
                    ->on('USG.employee_id','=','EMP.id')
                    ->where('USG.type',2) // 2 = admin
                    ->whereNull('ORG.deleted_at')
                    ->whereNull('USG.deleted_at');
            })
            ->select('ORG.id AS org_id','ORG.name AS org_name','ORG.org_code','ORG.address AS org_address','ORG.org_type','EMP.id AS employee_id','EMP.name AS employee_name','EMP.mobile_no','EMP.designation_id', 'USG.username','USG.id AS user_id')
            ->get();

        return $data ;
    }

}
