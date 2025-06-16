<?php

namespace App\Models;

use App\helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{

    protected $table = 'employees';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function list_data()
    {
        $data = DB::table('employees AS EMP')
            ->Join('users AS USG', function ($join) {
                $join->on('EMP.org_code', '=', 'EMP.org_code')
                    ->on('USG.employee_id', '=', 'EMP.id')
                    ->where('USG.org_code', GlobalHelper::getOrganizationCode())
                    ->where('EMP.org_code', GlobalHelper::getOrganizationCode())
                    ->whereNull('USG.deleted_at')
                    ->whereNull('EMP.deleted_at');
            })
            ->Join('designation AS DEG', function ($join) {
                $join->on('DEG.id', '=', 'EMP.designation_id')
                    ->whereNull('EMP.deleted_at')
                    ->whereNull('DEG.deleted_at');
            })
            ->where('EMP.org_code', GlobalHelper::getOrganizationCode())
            ->whereNull('EMP.deleted_at')
            ->select('EMP.id', 'EMP.name AS employee_name', 'EMP.mobile_no','EMP.email','EMP.image','DEG.id AS designation_id', 'DEG.name AS designation_name','USG.id AS user_id', 'USG.username', 'USG.type')
            ->get();
        return $data;
    }


    public function designation(){
       return $this->hasOne(Designation::class,'id','designation_id');
    }
}
