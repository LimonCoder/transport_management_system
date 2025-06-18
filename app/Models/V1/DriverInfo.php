<?php

namespace App\Models\V1;

use App\helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DriverInfo extends Model
{

    protected $table = 'driver_info';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['org_code','name','mobile_no','image'];

    public static function list_data(){
        $data = DB::table('driver_info AS DI')
            ->leftJoin('vehicle_setup AS VS',function($join) {
                $join->on('DI.org_code','=','VS.org_code')
                    ->on('VS.driver_id','=','DI.id')
                    ->where('VS.org_code',GlobalHelper::getOrganizationCode())
                    ->where('DI.org_code',GlobalHelper::getOrganizationCode())
                    ->whereNull('DI.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->where('DI.org_code',GlobalHelper::getOrganizationCode())
            ->whereNull('DI.deleted_at')
            ->select('DI.id','DI.name','DI.mobile_no','DI.image', 'VS.vehicle_reg_no')
            ->get();

        return $data;
    }

}
