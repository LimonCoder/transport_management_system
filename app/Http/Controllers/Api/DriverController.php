<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\DriverInfo;
use App\Models\Employee;
use App\Models\User;
use App\Models\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',


        ],
            [
                "name.required" => "কর্মকর্তার নাম প্রদান করুন",
            ]);

        if (!$validate->fails()) {


            $driver_data = [
                "org_code" => $request->org_code,
                "name" => $request->name,
                "mobile_no" => $request->mobile_no,
            ];


            if ($request->hasFile('picture')) {

                $fileName = '';
                $file = $request->file('picture');
                $file_name = Str::random(6) . '' . time() . '.' . $file->getClientOriginalExtension();

                $file->move(base_path('storage/app/public/drivers/'), $file_name);

                $driver_data['image'] = $file_name;
            }
            $driver_data['image'] = !empty($file_name) ? $file_name : 'default.png';
            $driver_data['created_at'] = Carbon::now();

//            echo "<pre>";
//            print_r($driver_data);
//            exit();

            // driver data store
            $response = DriverInfo::create($driver_data);


            $statusCode = $response ? 200 : 401;


            return response()->json([
                "status" => $response ? "success" : "error",
                "message" => $response ? "driver save success" : "Fail to save.Please try again"
            ])->setStatusCode($statusCode);


        } else {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong",
                "errors" => $validate->errors()
            ])->setStatusCode(401);
        }
    }


    public function list_data(Request $request)
    {

        $org_code = $request->org_code;

        $data = DB::table('driver_info AS DI')
            ->leftJoin('vehicle_setup AS VS',function($join) use ($org_code) {
                $join->on('DI.org_code','=','VS.org_code')
                    ->on('VS.driver_id','=','DI.id')
                    ->where('VS.org_code',$org_code)
                    ->where('DI.org_code',$org_code)
                    ->whereNull('DI.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->where('DI.org_code',$org_code)
            ->whereNull('DI.deleted_at')
            ->select('DI.id','DI.name','DI.mobile_no','DI.image', 'VS.vehicle_reg_no')
            ->get();

        $statusCode = $data ? 200 :401;

        return response()->json([
            "status" => $data ? "success" : "error",
            "message" => $data ? "Driver data found" : "Driver data not found",
            "data" => $data ? $data : [],
            "image_url" => url('/storage/app/public/drivers/')
        ])->setStatusCode($statusCode);
    }

    public function update(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required',


        ],
            [
                "name.required" => "কর্মকর্তার নাম প্রদান করুন",
            ]);

        if (!$validate->fails()) {


            $driver_data = [
                "org_code" => $request->org_code,
                "name" => $request->name,
                "mobile_no" => $request->mobile_no,
            ];


            if ($request->hasFile('picture')) {

                // previous image remove
                if ($request->previous_picture != "default.png") {
                    @unlink(base_path('storage/app/public/drivers/' . $request->previous_picture));
                }

                $fileName = '';
                $file = $request->file('picture');
                $file_name = Str::random(6) . '' . time() . '.' . $file->getClientOriginalExtension();

                $file->move(base_path('storage/app/public/drivers/'), $file_name);

                $driver_data['image'] = $file_name;
            }
            $driver_data['image'] = !empty($file_name) ? $file_name : 'default.png';
            $driver_data['updated_at'] = Carbon::now();

//            echo "<pre>";
//            print_r($driver_data);
//            exit();

            // driver data update
            $response = DriverInfo::where('id',$request->row_id)->update($driver_data);


            $statusCode = $response ? 200 : 401;


            return response()->json([
                "status" => $response ? "success" : "error",
                "message" => $response ? "driver update success" : "Fail to save.Please try again"
            ])->setStatusCode($statusCode);


        } else {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong",
                "errors" => $validate->errors()
            ])->setStatusCode(401);
        }
    }


    public function destroy(Request $request)
    {

        $org_code = $request->org_code;

        // check driver_data exists vehicle_setup table
        $isExists = DB::table((new VehicleSetup())->getTable())->where('driver_id', $request->row_id)->whereNull('deleted_at')->where('org_code',$org_code)->count() ?? 0;

        if ($isExists > 0) {
            return response()->json([
                "status" => "error",
                "message" => "You have already used this driver info for car registration"
            ])->setStatusCode(401);
        } else {
            $isDelete = DriverInfo::find($request->row_id)->delete();
            $statusCode = $isDelete ? 200 : 401;

            return response()->json([
                "status" => $isDelete ? "success" : "error",
                "message" => $isDelete ? "Driver delete success" : "Fail to delete.Please try again"
            ])->setStatusCode($statusCode);
        }

    }
}
