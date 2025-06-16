<?php

namespace App\models;

use App\helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class RentalCar extends Model
{
    protected $table = 'rental_car';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function list_data(){

        $data = DB::table('rental_car AS RC')
            ->Join('vehicle_setup AS VS',function($join) {
                $join->on('VS.id','=','RC.vehicle_id')
                    ->on('VS.org_code','=','RC.org_code')
                    ->whereNull('VS.deleted_at')
                    ->whereNull('RC.deleted_at');
            })
            ->where('RC.org_code',GlobalHelper::getOrganizationCode())
            ->whereNull('RC.deleted_at')
            ->select(DB::raw("RC.*"),'VS.body_type','VS.vehicle_reg_no')
            ->get();
//        dd($data);
        return $data;
    }
}
