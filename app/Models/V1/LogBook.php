<?php

namespace App\Models\V1;

use App\helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class LogBook extends Model
{

    protected $table = 'log_books';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public static function list_data(){
        $data = DB::table('log_books AS LB')
            ->Join('vehicle_setup AS VS',function($join) {
                $join->on('VS.id','=','LB.vehicle_id')
                    ->on('LB.org_code','=','VS.org_code')
                    ->whereNull('LB.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->Join('employees AS EM',function($join) {
                $join->on('EM.id','=','LB.employee_id')
                    ->on('LB.org_code','=','EM.org_code')
                    ->whereNull('LB.deleted_at')
                    ->whereNull('EM.deleted_at');
            })
            ->Join('designation AS DS',function($join) {
                $join->on('DS.id','=','EM.designation_id')
                    ->whereNull('EM.deleted_at')
                    ->whereNull('DS.deleted_at');
            })
            ->Join('driver_info AS DI',function($join) {
                $join->on('DI.id','=','LB.driver_id')
                    ->on('DI.org_code','=','LB.org_code')
                    ->whereNull('LB.deleted_at')
                    ->whereNull('DI.deleted_at');
            })
            ->Join('meter',function($join) {
                $join->on('LB.id','=','meter.log_book_id')
                    ->on('meter.org_code','=','LB.org_code')
                    ->whereNull('meter.deleted_at')
                    ->whereNull('LB.deleted_at');
            })
            ->Join('fuel_oil AS FO',function($join) {
                $join->on('LB.id','=','FO.log_book_id')
                    ->on('FO.org_code','=','LB.org_code')
                    ->whereNull('FO.deleted_at')
                    ->whereNull('LB.deleted_at');
            })
            ->where('LB.org_code',GlobalHelper::getOrganizationCode())
            ->whereNull('LB.deleted_at')
            ->select('VS.vehicle_reg_no','LB.id AS log_book_id', 'meter.id AS meter_id', 'FO.id AS fuel_oil_id',  'EM.name AS employee_name','DS.name AS designation_name','DI.name AS driver_name','LB.out_time','meter.in_time','LB.destination','LB.status')
            ->selectRaw("LB.driver_id,LB.vehicle_id, LB.employee_id,LB.from,LB.journey_time,LB.journey_cause,LB.insert_date,FO.type AS oil_type,FO.in,FO.out,FO.payment,meter.out_km,meter.in_km")
            ->orderBy('LB.id','DESC')
            ->get();
        return $data;
    }

}
