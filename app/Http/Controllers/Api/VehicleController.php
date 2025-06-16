<?php

namespace App\Http\Controllers\Api;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\DriverInfo;
use App\Models\Employee;
use App\Models\LogBook;
use App\Models\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $org_code = $request->org_code;

        $data['employees'] = Employee::where('org_code', $org_code)->whereNull('deleted_at')->get();
        $data['drivers'] = DriverInfo::where('org_code', $org_code)->whereNull('deleted_at')->get();


        return response()->json([
            "status" => $data ? "success" : "error",
            "message" => $data ? "employees & drivers data found " : "employees & drivers data not found",
            "data" => $data ? $data : []
        ]);

    }

    public function list_data(Request $request)
    {

        if (!isset($request->status)) {
            return response()->json([
                "status" => "error",
                "message" => "Status field is required"
            ])->setStatusCode(404);
        }

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
            ->where('VS.org_code', $request->org_code)
            ->whereNull('VS.deleted_at')
            ->where('VS.status', $request->status) // 1 = running
            ->select('DG.name AS designation_name', 'EM.name AS employee_name', 'DI.name AS driver_name', DB::raw("VS.*"))
            ->get();

        $statusCode = $data ? 200 : 404;

        return response()->json([
            "status" => $data ? "success" : "error",
            "message" => $data ? "Vehicle Data found" : "Vehicle data not found",
            "data" => $data ? $data : []
        ])->setStatusCode($statusCode);
    }

    public function store(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'employee_id' => ['required', 'numeric'],
            'driver_id' => ['required', 'numeric'],
            'vehicle_reg_no' => ['required', Rule::unique('vehicle_setup', 'vehicle_reg_no')->where('org_code',
                $request->org_code)->whereNull('deleted_at')],

        ],
            [
                "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
                "driver_id.required" => "ড্রাইভারের নাম প্রদান করুন",
                "vehicle_reg_no.required" => "গাড়ি রেজিস্ট্রেশন নং প্রদান করুন",
                "vehicle_reg_no.unique" => "এই গাড়ি রেজিস্ট্রেশন নং পূর্বে ব্যবহার করা হয়েছে",
            ]);

        if (!$validate->fails()) {

            $vehicle_data = [
                "org_code" => $request->org_code,
                "employee_id" => $request->employee_id,
                "driver_id" => $request->driver_id,
                "vehicle_reg_no" => $request->vehicle_reg_no,
                "body_type" => $request->body_type,
                "chassis_no" => $request->chassis_no,
                "engine_no" => $request->engine_no,
                "develop_year" => $request->develop_year,
                "fitness_duration" => $request->fitness_duration,
                "tax_token_duration" => $request->tax_token_duration,
                "assignment_date" => $request->assignment_date,
                "status" => 1, // 1 = running
                "created_at" => Carbon::now()
            ];

            if ($request->has('picture')) {
                $images = '';
               
                $file = $request->picture;
                
                 $file_name = Str::random(6) . time() . '.' . $file->extension();

                    $file->move(base_path('storage/app/public/vehicles/'), $file_name);

                    $vehicle_data['images'] = $file_name;
                    
                    
            } else {
                $vehicle_data['images'] = 'default.png';
            }


            $isSave = DB::table((new VehicleSetup())->getTable())->insert($vehicle_data);

            $statusCode = $isSave ? 200 : 404;

            return response()->json([
                "status" => $isSave ? "success" : "error",
                "message" => $isSave ? "Vehicle save success" : "Fail to save.Please try again"
            ])->setStatusCode($statusCode);


        } else {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong",
                "errors" => $validate->errors()
            ])->setStatusCode(402);
        }


    }


    public function update(Request $request)
    {
        $org_code = $request->org_code;

        $validate = Validator::make($request->all(), [
            'employee_id' => ['required', 'numeric'],
            'driver_id' => ['required', 'numeric'],

        ],
            [
                "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
                "driver_id.required" => "ড্রাইভারের নাম প্রদান করুন",
                "vehicle_reg_no.required" => "গাড়ি রেজিস্ট্রেশন নং প্রদান করুন",
                "vehicle_reg_no.unique" => "এই গাড়ি রেজিস্ট্রেশন নং পূর্বে ব্যবহার করা হয়েছে",
            ]);

        $validate->sometimes('vehicle_reg_no', [Rule::unique('vehicle_setup', 'vehicle_reg_no')->where('org_code',
            $org_code)->whereNull('deleted_at')], function ($input) use ($org_code){

            $isExist = VehicleSetup::where('org_code', $org_code)->where('vehicle_reg_no',
                $input->vehicle_reg_no)->where('id', '!=', $input->row_id)->first();

            return !empty($isExist) ? true : false;
        });

        if (!$validate->fails()) {

            $vehicle_data = [
                "org_code" => $org_code,
                "employee_id" => $request->employee_id,
                "driver_id" => $request->driver_id,
                "vehicle_reg_no" => $request->vehicle_reg_no,
                "body_type" => $request->body_type,
                "chassis_no" => $request->chassis_no,
                "engine_no" => $request->engine_no,
                "develop_year" => $request->develop_year,
                "fitness_duration" => $request->fitness_duration,
                "tax_token_duration" => $request->tax_token_duration,
                "assignment_date" => $request->assignment_date,
                "status" => 1, // 1 = running
                "updated_at" => Carbon::now()
            ];

            if ($request->has('picture')) {
                $images = '';
                $total_image = count($request->picture);
                foreach ($request->picture as $key => $file) {

                    $file_name = Str::random(6) . time() . '.' . $file->extension();

                    $file->move(base_path('storage/app/public/vehicles/'), $file_name);

                    $images .= (($key + 1) != $total_image) ? $file_name . "##" : $file_name;
                }
                $vehicle_data['images'] = $images;
            }


            $isUpdate = DB::table((new VehicleSetup())->getTable())->where('id', $request->row_id)->update
            ($vehicle_data);

            $statusCode = $isUpdate ? 200 : 404;

            return response()->json([
                "status" => $isUpdate ? "success" : "error",
                "message" => $isUpdate ? "Vehicle update success" : "Fail to update.Please try again"
            ],$statusCode);


        } else {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong",
                "errors" => $validate->errors()
            ],404);
        }

    }


    public function destroy(Request $request)
    {

        $org_code = $request->org_code;

        // check vehicle exists log_books table
        $isExists = DB::table((new LogBook())->getTable())->where('vehicle_id', $request->row_id)->where('org_code',$org_code)
                ->whereNull('deleted_at')->count() ?? 0;

        if ($isExists > 0) {
            return response()->json([
                "status" => "error",
                "message" => "You have already used this vehicle number in the log book"
            ]);
        } else {
            $isDelete = VehicleSetup::find($request->row_id)->delete();

            return response()->json([
                "status" => $isDelete ? "success" : "error",
                "message" => $isDelete ? "Vehicle delete success" : "Fail to delete.Please try again"
            ]);
        }

    }


    public function uselessVehicleStore(Request $request)
    {

        $isUpdate = DB::table((new VehicleSetup())->getTable())->where("id", $request->vehicle_id)->update([
            "useless_date" => $request->useless_date,
            "updated_at" => Carbon::now(),
            "status" => 0 // 0 = useless
        ]);

        $statusCode = $isUpdate ? 200 : 401;

        return response()->json([
            "status" => $isUpdate ? "success" : "error",
            "message" => $isUpdate ? "Useless vehicle save success" : "Fail to save.Please try again"
        ],$statusCode);

    }

}
