<?php

namespace App\Http\Controllers\Api;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\DriverInfo;
use App\Models\Employee;
use App\Models\LogBook;
use App\Models\Repairs;
use App\Models\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RepairsController extends Controller
{
    public function index(Request $request)
    {
        $org_code = $request->org_code;
        $data['employees'] = Employee::where('org_code', $org_code)->whereNull('deleted_at')->get();
        $data['vehicles'] = VehicleSetup::where('org_code', $org_code)->whereNull('deleted_at')->get();

        return response()->json([
            "status" => "success",
            "message" => "data found",
            "data" => $data
        ], 200);
    }


    public function list_data(Request $request)
    {

        $org_code = $request->org_code;

        $data = DB::table('repairs AS REP')
            ->Join('vehicle_setup AS VS', function ($join) {
                $join->on('VS.id', '=', 'REP.vehicle_id')
                    ->on('REP.org_code', '=', 'VS.org_code')
                    ->whereNull('REP.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->Join('driver_info AS DI', function ($join) {
                $join->on('DI.id', '=', 'VS.driver_id')
                    ->on('VS.org_code', '=', 'DI.org_code')
                    ->whereNull('DI.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->Join('employees AS EMP', function ($join) {
                $join->on('EMP.id', '=', 'REP.employee_id')
                    ->on('REP.org_code', '=', 'EMP.org_code')
                    ->whereNull('REP.deleted_at')
                    ->whereNull('EMP.deleted_at');
            })
            ->where('REP.org_code', $org_code)
            ->whereNull('REP.deleted_at')
            ->select(DB::raw("REP.*"), 'VS.vehicle_reg_no', 'EMP.name AS employee_name', 'DI.name AS driver_name')
            ->orderBy('REP.created_at', 'DESC')
            ->paginate(50);

        return response()->json([
            "status" => "success",
            "message" => "Repairs data found",
            "data" => $data
        ], 200);
    }

    public function store(Request $request)
    {

        $org_code = $request->org_code;

        $validate = Validator::make($request->all(), [
            'vehicle_id' => ['required', 'numeric'],
            'employee_id' => ['required', 'numeric'],
        ],
            [
                "vehicle_id.required" => "গাড়ির নং প্রদান করুন",
                "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
            ]);

        if (!$validate->fails()) {
            $repairs_data = [
                "org_code" => $org_code,
                "vehicle_id" => $request->vehicle_id,
                "employee_id" => $request->employee_id,
                "damage_parts" => $request->damage_parts,
                "new_parts" => $request->new_parts,
                "shop_name" => $request->shop_name,
                "total_cost" => $request->total_cost,
                "cause_of_problems" => $request->cause_of_problems,
                "insert_date" => $request->insert_date,
                "created_at" => Carbon::now()
            ];

            $isSave = DB::table((new Repairs())->getTable())->insert($repairs_data);

            return response()->json([
                "status" => $isSave ? "success" : "error",
                "message" => $isSave ? "repairs save success" : "Fail to save.Please try again"
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Fail to save.Please try again",
                "errors" => $validate->errors()
            ], 401);
        }
    }

    public function update(Request $request){
        $org_code = $request->org_code;

        $validate = Validator::make($request->all(), [
            'vehicle_id' => ['required', 'numeric'],
            'employee_id' => ['required', 'numeric'],
        ],
            [
                "vehicle_id.required" => "গাড়ির নং প্রদান করুন",
                "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
            ]);

        if (!$validate->fails()) {
            $repairs_data = [
                "org_code" => $org_code,
                "vehicle_id" => $request->vehicle_id,
                "employee_id" => $request->employee_id,
                "damage_parts" => $request->damage_parts,
                "new_parts" => $request->new_parts,
                "shop_name" => $request->shop_name,
                "total_cost" => $request->total_cost,
                "cause_of_problems" => $request->cause_of_problems,
                "insert_date" => $request->insert_date,
                "updated_at" => Carbon::now()
            ];

            $isUpdate = DB::table((new Repairs())->getTable())->where('id',$request->row_id)->update($repairs_data);

            return response()->json([
                "status" => $isUpdate ? "success" : "error",
                "message" => $isUpdate ? "repairs update success" : "Fail to update.Please try again"
            ], 200);
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Fail to update.Please try again",
                "errors" => $validate->errors()
            ], 401);
        }
    }

    public function destroy(Request $request){

        $isDelete = Repairs::find($request->row_id)->delete();
        $statusCode = $isDelete ? 200 : 401;

        return response()->json([
            "status" => $isDelete ? "success" : "error",
            "message" => $isDelete ? "repairs delete success" : "Fail to delete.Please try again"
        ])->setStatusCode($statusCode);
    }
}
