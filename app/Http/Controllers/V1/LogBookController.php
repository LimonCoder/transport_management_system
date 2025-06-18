<?php

namespace App\Http\Controllers\V1;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
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
use Yajra\DataTables\Facades\DataTables;

class LogBookController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['employees'] = Employee::with('designation')->where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();

        $data['drivers'] = DriverInfo::where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();

        $data['vehicles'] = VehicleSetup::where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')
            ->get();

        return view('log_books', $data);
    }

    public function list_data()
    {
        $data = LogBook::list_data();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function store(Request $request)
    {
//        dd($request->all());

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

        ], [
            "driver_id.required" => "ড্রাইভারের নাম প্রদান করুন",
            "vehicle_id.required" => "গাড়িং নং নির্বাচন করুন",
            "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
            "insert_date.required" => "তারিখ প্রদান করুন",
            "from.required" => "হইতে প্রদান করুন",
            "out_time.required" => "বাহির হওয়ার সময় প্রদান করুন",
            "destination.required" => "গন্তব্য স্থান প্রদান করুন",
        ]);

        if (!$validate->fails()) {

            DB::beginTransaction();
            try {

                $logs_book_data = [
                    "org_code" => GlobalHelper::getOrganizationCode(),
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
                    "org_code" => GlobalHelper::getOrganizationCode(),
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
                    "org_code" => GlobalHelper::getOrganizationCode(),
                    "vehicle_id" => $request->vehicle_id,
                    "log_book_id" => $log_book_id,
                    "type" => $request->type,
                    "out" => $request->out,
                    "in" => $request->in,
                    "previous_stock"=>$request->previous_stock,
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
                    "message" => "সফলভাবে লগবইতে এন্টি হয়েছে"
                ]);

            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    "status" => "error",
                    "title" => "ব্যর্থ",
                    "message" => "কোন সমস্যা আছে",
                    "error" => $exception->getMessage()
                ]);
            }


        } else {
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "কোন সমস্যা আছে",
                "errors" => $validate->errors()
            ]);
        }
    }


    public function edit($id)
    {

    }


    public function update(Request $request)
    {
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

        ], [
            "driver_id.required" => "ড্রাইভারের নাম প্রদান করুন",
            "vehicle_id.required" => "গাড়িং নং নির্বাচন করুন",
            "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
            "insert_date.required" => "তারিখ প্রদান করুন",
            "from.required" => "হইতে প্রদান করুন",
            "out_time.required" => "বাহির হওয়ার সময় প্রদান করুন",
            "destination.required" => "গন্তব্য স্থান প্রদান করুন",
        ]);

        if (!$validate->fails()) {

            DB::beginTransaction();
            try {

                $logs_book_data = [
                    "org_code" => GlobalHelper::getOrganizationCode(),
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
                    "org_code" => GlobalHelper::getOrganizationCode(),
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
                    "org_code" => GlobalHelper::getOrganizationCode(),
                    "vehicle_id" => $request->vehicle_id,
                    "log_book_id" => $log_book_id,
                    "type" => $request->type,
                    "out" => $request->out,
                    "in" => $request->in,
                    "previous_stock"=>$request->previous_stock,
                    "payment" => $request->payment,
                    "updated_at" => Carbon::now()
                ];

                // oil data update //
                DB::table((new FuelOil())->getTable())->where('id', $request->fuel_oi_id)->update($fuel_oil_data);


                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "title" => "সফল",
                    "message" => "সফলভাবে লগবইয়ের ডাটা আপডেট হয়েছে"
                ]);

            } catch (\Exception $exception) {
                DB::rollback();
                return response()->json([
                    "status" => "error",
                    "title" => "ব্যর্থ",
                    "message" => "কোন সমস্যা আছে",
                    "error" => $exception->getMessage()
                ]);
            }


        } else {
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "কোন সমস্যা আছে",
                "errors" => $validate->errors()
            ]);
        }
    }


    public function destroy(Request $request)
    {

        DB::beginTransaction();
        try {
            LogBook::find($request->log_book_id)->delete();
            Meter::find($request->meter_id)->delete();
            FuelOil::find($request->fuel_oil_id)->delete();

            DB::commit();

            return response()->json([
                "status" => "success",
                "title" => "সফল",
                "message" => "সফলভাবে ডিলিট হয়েছে"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "কোন সমস্যা আছে",
            ]);
        }
    }


    public function getCurrentStock(Request $r)
    {
        $data = FuelOil::current_stock($r->vehicle_id, $r->log_book_id);

        return response()->json([
            "status" => "success",
            "data" => $data

        ]);
    }

}

?>
