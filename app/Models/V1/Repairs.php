<?php

namespace App\Models\V1;

use App\helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Repairs extends Model
{

    protected $table = 'repairs';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function list_data()
    {
        $data = DB::table('repairs AS REP')
            ->Join('vehicle_setup AS VS', function ($join) {
                $join->on('VS.id', '=', 'REP.vehicle_id')
                    ->on('REP.org_code','=','VS.org_code')
                    ->whereNull('REP.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->Join('driver_info AS DI', function ($join) {
                $join->on('DI.id', '=', 'VS.driver_id')
                    ->on('VS.org_code','=','DI.org_code')
                    ->whereNull('DI.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->Join('employees AS EMP', function ($join) {
                $join->on('EMP.id', '=', 'REP.employee_id')
                        ->on('REP.org_code','=','EMP.org_code')
                    ->whereNull('REP.deleted_at')
                    ->whereNull('EMP.deleted_at');
            })
            ->where('REP.org_code', GlobalHelper::getOrganizationCode())
            ->whereNull('REP.deleted_at')
            ->select(DB::raw("REP.*"),'VS.vehicle_reg_no', 'EMP.name AS employee_name', 'DI.name AS driver_name')
            ->orderBy('REP.created_at', 'DESC')
            ->get();
        return $data;
    }
}
