<?php

namespace App\Models\V1;

use App\helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class VehicleSetup extends Model
{

    protected $table = 'vehicle_setup';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function list_data($status = 1)
    {
        $data = DB::table('vehicle_setup AS VS')
            ->Join('employees AS EM', function ($join) {
                $join->on('EM.id', '=', 'VS.employee_id')
                    ->on('EM.org_code', '=', 'VS.org_code')
                    ->whereNull('VS.deleted_at')
                    ->whereNull('EM.deleted_at');
            })
            ->Join('designation AS DG', function ($join) {
                $join->on('EM.designation_id', '=', 'DG.id')
                    ->whereNull('DG.deleted_at')
                    ->whereNull('EM.deleted_at');
            })
            ->Join('driver_info AS DI', function ($join) {
                $join->on('DI.id', '=', 'VS.driver_id')
                    ->on('DI.org_code', '=', 'VS.org_code')
                    ->whereNull('VS.deleted_at')
                    ->whereNull('DI.deleted_at');
            })
            ->where('VS.org_code', GlobalHelper::getOrganizationCode())
            ->whereNull('VS.deleted_at')
            ->where('VS.status', $status) // 1 = running
            ->select(DB::raw("VS.*"),'DG.name AS designation_name', 'EM.name AS employee_name', 'DI.name AS driver_name')
            ->get();
        return $data;
    }
    public function driver_info(){
        return $this->hasOne(DriverInfo::class,'id','driver_id');
    }

}
