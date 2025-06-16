<?php

namespace App\Http\Controllers;

use App\helpers\GlobalHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleSetup;
use App\Models\Repairs;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{

    public function employee_report($org_code = null)
    {
        $data['org'] = GlobalHelper::getOrganizationInfo($org_code);

        $data['org_code'] = is_null($org_code) ? GlobalHelper::getOrganizationCode() : $org_code;

        $data['employee'] = DB::table('employees AS EMP')
            ->Join('users AS USG', function ($join) use ($data) {
                $join->on('EMP.org_code', '=', 'EMP.org_code')
                    ->on('USG.employee_id', '=', 'EMP.id')
                    ->where('USG.org_code', $data['org_code'])
                    ->where('EMP.org_code', $data['org_code'])
                    ->whereNull('USG.deleted_at')
                    ->whereNull('EMP.deleted_at');
            })
            ->Join('designation AS DEG', function ($join) {
                $join->on('DEG.id', '=', 'EMP.designation_id')
                    ->whereNull('EMP.deleted_at')
                    ->whereNull('DEG.deleted_at');
            })
            ->where('EMP.org_code', $data['org_code'])
            ->whereNull('EMP.deleted_at')
            ->select('EMP.id', 'EMP.name AS employee_name', 'EMP.mobile_no', 'EMP.email', 'EMP.image', 'DEG.id AS designation_id', 'DEG.name AS designation_name', 'USG.id AS user_id', 'USG.username', 'USG.type')
            ->get();

        return view('report.employee_report', $data);

    }

//Driver Report
    public function driver_report($org_code = null)
    {

        $data['org'] = GlobalHelper::getOrganizationInfo($org_code);

        $data['org_code'] = is_null($org_code) ? GlobalHelper::getOrganizationCode() : $org_code;

        $data['driver_info'] = DB::table('driver_info AS DI')
            ->leftJoin('vehicle_setup AS VS', function ($join) use ($data) {
                $join->on('DI.org_code', '=', 'VS.org_code')
                    ->on('VS.driver_id', '=', 'DI.id')
                    ->where('VS.org_code', $data['org_code'])
                    ->where('DI.org_code', $data['org_code'])
                    ->whereNull('DI.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->where('DI.org_code', $data['org_code'])
            ->whereNull('DI.deleted_at')
            ->select('DI.id', 'DI.name', 'DI.mobile_no', 'DI.image', 'VS.vehicle_reg_no')
            ->get();

        return view('report.driver_report', $data);

    }

// repairs_report

    public function repairs(Request $request)
    {

        $data['vehicle'] = VehicleSetup::list_data();
        return view('report.repairs', $data);
    }

    public function repairs_report_print(Request $request)
    {


        $data['vehicle_reg_no'] = $request->vehicle_reg_no;
        $data['from'] = $request->from_date;
        $data['to'] = $request->to_date;

        $data['org'] = GlobalHelper::getOrganizationInfo($request->org_code);

        $data['org_code'] = is_null($data['org']) ? GlobalHelper::getOrganizationCode() : $data['org']->org_code;



        $data['repairs_data'] = DB::table('repairs AS REP')
            ->Join('vehicle_setup AS VS', function ($join) {
                $join->on('VS.id', '=', 'REP.vehicle_id')
                    ->on('REP.org_code', '=', 'VS.org_code')
                    ->on('VS.vehicle_reg_no', '=', 'VS.vehicle_reg_no')
                    ->whereNull('VS.deleted_at')
                    ->whereNull('REP.deleted_at');
            })
            ->Join('driver_info AS DI', function ($join) {
                $join->on('DI.id', '=', 'VS.driver_id')
                    ->on('VS.org_code', '=', 'VS.org_code')
                    ->whereNull('DI.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->where('REP.org_code', $data['org_code'])
            ->whereNull('REP.deleted_at')
            ->select('DI.name AS driver_name', 'VS.vehicle_reg_no', 'REP.id', 'REP.damage_parts', 'REP.new_parts','REP.shop_name', 'REP.total_cost', 'REP.cause_of_problems','REP.insert_date as issue_date')
            ->when(!empty($data['vehicle_reg_no']), function ($query) use ($data) {
                $query->where('VS.vehicle_reg_no', $data['vehicle_reg_no']);
            })
            ->whereDate('REP.created_at', '>=', $data['from'])
            ->whereDate('REP.created_at', '<=', $data['to'])
            ->get();

        return view('report.repairs_report_print', $data);
    }

//Rental Report

    public function rentalcar()
    {
        return view('report.rentalcar_report');
    }

    public function rentalcar_report_print(Request $request)
    {

        $data['from'] = $request->from_date;
        $data['to'] = $request->to_date;
        $data['org'] = GlobalHelper::getOrganizationInfo($request->org_code);
        $data['org_code'] = is_null($data['org']) ? GlobalHelper::getOrganizationCode() : $data['org']->org_code;

        $data['rentalcar_info'] = DB::table('rental_car AS RC')
            ->Join('vehicle_setup AS VS', function ($join) {
                $join->on('VS.id', '=', 'RC.vehicle_id')
                    ->on('VS.org_code', '=', 'RC.org_code')
                    ->whereNull('VS.deleted_at')
                    ->whereNull('RC.deleted_at');
            })
            ->where('RC.org_code', $data['org_code'])
            ->whereNull('RC.deleted_at')
            ->select(DB::raw("RC.*"), 'VS.body_type', 'VS.vehicle_reg_no')
            ->whereDate('RC.created_at', '>=', $data['from'])
            ->whereDate('RC.created_at', '<=', $data['to'])
            ->get();

//    dd($data);

        return view('report.rentalcar_report_print', $data);
    }

//lubricant report
    public function lubricant()
    {

        $data['vehicle'] = VehicleSetup::list_data();
        return view('report.lubricant', $data);
    }

    public function lubricant_report_print(Request $request)
    {

        $data['vehicle_reg_no'] = $request->vehicle_reg_no;
        $data['from'] = $request->from_date;
        $data['to'] = $request->to_date;

        $data['org'] = GlobalHelper::getOrganizationInfo($request->org_code);

        $data['org_code'] = is_null($data['org']) ? GlobalHelper::getOrganizationCode() : $data['org']->org_code;

      //  dd($data);





        $data['lubricant_data'] = DB::table('fuel_oil AS FO')
            ->Join('vehicle_setup AS VS', function ($join) {
                $join->on('VS.id', '=', 'FO.vehicle_id')
                    ->on('FO.org_code', '=', 'VS.org_code')
                    ->whereNull('FO.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->Join('driver_info AS DI', function ($join) {
                $join->on('DI.id', '=', 'VS.driver_id')
                    ->on('DI.org_code', '=', 'VS.org_code')
                    ->whereNull('DI.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->where('FO.org_code', $data['org_code'])
            ->whereNull('DI.deleted_at')
            ->select('DI.name AS driver_name', 'VS.vehicle_reg_no', 'FO.type', 'FO.in', 'FO.payment', 'FO.created_at', 'FO.previous_stock')
            ->when(!empty($data['vehicle_reg_no']), function ($query) use ($data) {
                $query->where('VS.vehicle_reg_no', $data['vehicle_reg_no']);
            })
            ->whereDate('FO.created_at', '>=', $data['from'])
            ->whereDate('FO.created_at', '<=', $data['to'])
            ->get();

        return view('report.lubricant_report_print', $data);
    }

//Useless Report

    public function useless()
    {
        return view('report.useless');
    }

    public static function useless_report_print($from, $to, $org_code = null)
    {
        $data['from'] = $from;
        $data['to'] = $to;
        $data['org'] = GlobalHelper::getOrganizationInfo($org_code);
        $data['org_code'] = is_null($org_code) ? GlobalHelper::getOrganizationCode() : $org_code;
        $status = 0;

        $data['useless_data'] = DB::table('vehicle_setup AS VS')
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
            ->where('VS.org_code', $data['org_code'])
            ->whereNull('VS.deleted_at')
            ->where('VS.status', $status)
            ->whereDate('VS.created_at', '>=', $from)
            ->whereDate('VS.created_at', '<=', $to)
            ->select(DB::raw("VS.*"), 'DG.name AS designation_name', 'EM.name AS employee_name', 'DI.name AS driver_name')
            ->get();

        return view('report.useless_report_print', $data);
    }

//Log Book Report
    public function log_book()
    {
        $data['vehicle'] = VehicleSetup::list_data();
        return view('report.log_book', $data);
    }

    public function log_book_report_print($from, $to, $org_code = null)
    {
        $data['from'] = $from;
        $data['to'] = $to;
        $data['org'] = GlobalHelper::getOrganizationInfo($org_code);
        $data['org_code'] = is_null($org_code) ? GlobalHelper::getOrganizationCode() : $org_code;

        $data['log_book_data'] = DB::table('log_books AS LB')
            ->Join('vehicle_setup AS VS', function ($join) {
                $join->on('VS.id', '=', 'LB.vehicle_id')
                    ->on('LB.org_code', '=', 'VS.org_code')
                    ->whereNull('LB.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->Join('employees AS EM', function ($join) {
                $join->on('EM.id', '=', 'LB.employee_id')
                    ->on('LB.org_code', '=', 'EM.org_code')
                    ->whereNull('LB.deleted_at')
                    ->whereNull('EM.deleted_at');
            })
            ->Join('designation AS DS', function ($join) {
                $join->on('DS.id', '=', 'EM.designation_id')
                    ->whereNull('EM.deleted_at')
                    ->whereNull('DS.deleted_at');
            })
            ->Join('driver_info AS DI', function ($join) {
                $join->on('DI.id', '=', 'LB.driver_id')
                    ->on('DI.org_code', '=', 'LB.org_code')
                    ->whereNull('LB.deleted_at')
                    ->whereNull('DI.deleted_at');
            })
            ->Join('meter', function ($join) {
                $join->on('LB.id', '=', 'meter.log_book_id')
                    ->on('meter.org_code', '=', 'LB.org_code')
                    ->whereNull('meter.deleted_at')
                    ->whereNull('LB.deleted_at');
            })
            ->Join('fuel_oil AS FO', function ($join) {
                $join->on('LB.id', '=', 'FO.log_book_id')
                    ->on('FO.org_code', '=', 'LB.org_code')
                    ->whereNull('FO.deleted_at')
                    ->whereNull('LB.deleted_at');
            })
            ->where('LB.org_code', $data['org_code'])
            ->whereNull('LB.deleted_at')
            ->whereDate('LB.created_at', '>=', $from)
            ->whereDate('LB.created_at', '<=', $to)
            ->select('VS.vehicle_reg_no', 'LB.id AS log_book_id', 'meter.id AS meter_id', 'FO.id AS fuel_oil_id', 'EM.name AS employee_name', 'DS.name AS designation_name', 'DI.name AS driver_name', 'LB.out_time', 'meter.in_time', 'LB.destination', 'LB.status', 'LB.destination', 'FO.previous_stock', 'FO.previous_stock')
            ->selectRaw("LB.driver_id,LB.vehicle_id, LB.employee_id,LB.from,LB.journey_time,LB.journey_cause,LB.insert_date,FO.type AS oil_type,FO.in,FO.out,FO.payment,meter.out_km,meter.in_km,(FO.previous_stock + FO.in)-FO.out AS total_stock")
            ->orderBy('LB.id', 'DESC')
            ->get();

        return view('report.log_book_report_print', $data);
    }

}
