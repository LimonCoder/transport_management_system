<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\DriverInfo;
use App\Models\V1\Employee;
use App\Models\V1\FuelOil;
use App\Models\V1\LogBook;
use App\Models\V1\Meter;
use App\Models\V1\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LogBookController extends Controller
{
    public function index(Request $request)
    {
        $org_code = $request->org_code;
        $data['employees'] = Employee::with('designation')->where('org_code', $org_code)
            ->whereNull('deleted_at')
            ->get();
        $data['drivers'] = DriverInfo::where('org_code', $org_code)->whereNull('deleted_at')->get();
        $data['vehicles'] = VehicleSetup::where('org_code', $org_code)->whereNull('deleted_at')
            ->get();

        return response()->json([
            "status" => "success",
            "message" => "data found",
            "data" => $data
        ],200);
    }



    public function list_data(Request $request){
        $org_code = $request->org_code;

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
            ->where('LB.org_code',$org_code)
            ->whereNull('LB.deleted_at')
            ->select('VS.vehicle_reg_no','LB.id AS log_book_id', 'meter.id AS meter_id', 'FO.id AS fuel_oil_id',  'EM.name AS employee_name','DS.name AS designation_name','DI.name AS driver_name','LB.out_time','meter.in_time','LB.destination','LB.status')
            ->selectRaw("LB.driver_id,LB.vehicle_id, LB.employee_id,LB.from,LB.journey_time,LB.journey_cause,LB.insert_date,FO.type AS oil_type,FO.in,FO.out,FO.payment,meter.out_km,meter.in_km")
            ->orderBy('LB.id','DESC')
            ->get();


        $statusCode = $data ?200 :401;

        return response()->json([
            "status" => $data ? "success":"error",
            "message" => $data ? "logbook data found":"logbook data not found",
            "data" => $data ? $data : []
        ],$statusCode);
    }


    public function store(Request $request)
    {

        $org_code = $request->org_code;

        $validate = Validator::make($request->all(), [
            'driver_id' => 'required',
            'vehicle_id' => 'required',
            'employee_id' => 'required',
            'insert_date' => 'required',
            'from' => 'required',
            'out_time' => 'required',
            'destination' => 'required',
            'out_km' => 'required',
            'in_km' => 'required',
            'type' => 'required',
            'in' => 'required',
            'out' => 'required',
            'payment' => 'required'

        ]);

        if (!$validate->fails()) {

            DB::beginTransaction();
            try {

                $logs_book_data = [
                    "org_code" => $org_code,
                    "driver_id" => $request->driver_id,
                    "employee_id" => $request->employee_id,
                    "vehicle_id" => $request->vehicle_id,
                    "from" => $request->from,
                    "out_time" => $request->out_time,
                    "destination" => $request->destination,
                    "journey_time" => $request->journey_time,
                    "journey_cause" => $request->journey_cause,
                    "insert_date" => $request->insert_date,
                    "status" => 1,
                    "created_at" => Carbon::now()
                ];

                // logs data store
                $log_book_id = DB::table((new LogBook())->getTable())->insertGetId($logs_book_data);


                $meter_data = [
                    "org_code" => $org_code,
                    "vehicle_id" => $request->vehicle_id,
                    "log_book_id" => $log_book_id,
                    "out_km" => $request->out_km,
                    "in_km" => $request->in_km,
                    "in_time" => $request->in_time,
                    "created_at" => Carbon::now()
                ];

                // meter data store
                DB::table((new Meter())->getTable())->insert($meter_data);

                $fuel_oil_data = [
                    "org_code" => $org_code,
                    "vehicle_id" => $request->vehicle_id,
                    "log_book_id" => $log_book_id,
                    "type" => $request->type,
                    "out" => $request->out,
                    "in" => $request->in,
                    "payment" => $request->payment,
                    "created_at" => Carbon::now()
                ];

                // oil data store //
                DB::table((new FuelOil())->getTable())->insert($fuel_oil_data);


                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "title" => "সফল",
                    "message" => "logbook record save success"
                ],200);

            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    "status" => "error",
                    "message" => "Something went wrong",
                    "error" => $exception->getMessage()
                ],401);
            }


        } else {
            return response()->json([
                "status" => "error",
                "message" => "কোন সমস্যা আছে",
                "errors" => $validate->errors()
            ],401);
        }
    }

    public function update(Request $request)
    {
        $org_code = $request->org_code;
        $validate = Validator::make($request->all(), [
            'driver_id' => 'required',
            'vehicle_id' => 'required',
            'employee_id' => 'required',
            'insert_date' => 'required',
            'from' => 'required',
            'out_time' => 'required',
            'destination' => 'required',
            'out_km' => 'required',
            'in_km' => 'required',
            'type' => 'required',
            'in' => 'required',
            'out' => 'required',
            'payment' => 'required',

        ]);

        if (!$validate->fails()) {

            DB::beginTransaction();
            try {

                $logs_book_data = [
                    "org_code" => $org_code,
                    "driver_id" => $request->driver_id,
                    "employee_id" => $request->employee_id,
                    "vehicle_id" => $request->vehicle_id,
                    "from" => $request->from,
                    "out_time" => $request->out_time,
                    "destination" => $request->destination,
                    "journey_time" => $request->journey_time,
                    "journey_cause" => $request->journey_cause,
                    "insert_date" => $request->insert_date,
                    "status" => 1,
                    "updated_at" => Carbon::now()
                ];

                // logs data update
                $log_book_id = DB::table((new LogBook())->getTable())->where('id', $request->log_book_id)->update($logs_book_data);


                $meter_data = [
                    "org_code" => $org_code,
                    "vehicle_id" => $request->vehicle_id,
                    "log_book_id" => $log_book_id,
                    "out_km" => $request->out_km,
                    "in_km" => $request->in_km,
                    "in_time" => $request->in_time,
                    "updated_at" => Carbon::now()
                ];

                // meter data update
                DB::table((new Meter())->getTable())->where('id', $request->meter_id)->update($meter_data);

                $fuel_oil_data = [
                    "org_code" => $org_code,
                    "vehicle_id" => $request->vehicle_id,
                    "log_book_id" => $log_book_id,
                    "type" => $request->type,
                    "out" => $request->out,
                    "in" => $request->in,
                    "payment" => $request->payment,
                    "updated_at" => Carbon::now()
                ];

                // oil data update //
                DB::table((new FuelOil())->getTable())->where('id', $request->fuel_oil_id)->update($fuel_oil_data);


                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "message" => "logbook record update success"
                ],200);

            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    "status" => "error",
                    "message" => "Something went wrong",
                    "error" => $exception->getMessage()
                ],401);
            }


        } else {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong",
                "errors" => $validate->errors()
            ],401);
        }
    }


    public function destroy(Request $request)
    {

        $org_code = $request->org_code;

        DB::beginTransaction();
        try {
            LogBook::find($request->log_book_id)->delete();
            Meter::find($request->meter_id)->delete();
            FuelOil::find($request->fuel_oil_id)->delete();

            DB::commit();

            return response()->json([
                "status" => "success",
                "message" => "logbook record delete succes"
            ],200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong",
            ],401);
        }
    }
}
