<?php

namespace App\Http\Controllers;

use App\helpers\GlobalHelper;
use App\Models\DriverInfo;
use App\Models\Employee;
use App\Models\LogBook;
use App\Models\User;
use App\Models\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class VehicleSetupController extends Controller
{

    public function index()
    {
        $data['employees'] = Employee::where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();
        $data['drivers'] = DriverInfo::where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();
        return view('vehicle_setup', $data);

    }


    public function list_data()
    {
        $data = VehicleSetup::list_data();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function store(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'employee_id' => ['required', 'numeric'],
            'driver_id' => ['required', 'numeric'],
            'vehicle_reg_no' => ['required', Rule::unique('vehicle_setup', 'vehicle_reg_no')->where('org_code',
                GlobalHelper::getOrganizationCode())->whereNull('deleted_at')],

        ],
            [
                "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
                "driver_id.required" => "ড্রাইভারের নাম প্রদান করুন",
                "vehicle_reg_no.required" => "গাড়ি রেজিস্ট্রেশন নং প্রদান করুন",
                "vehicle_reg_no.unique" => "এই গাড়ি রেজিস্ট্রেশন নং পূর্বে ব্যবহার করা হয়েছে",
            ]);

        if (!$validate->fails()) {

            $vehicle_data = [
                "org_code" => GlobalHelper::getOrganizationCode(),
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
                $total_image = count($request->picture);
                foreach ($request->picture as $key => $file) {

                    $file_name = Str::random(6) . time() . '.' . $file->extension();

                    $file->move(base_path('storage/app/public/vehicles/'), $file_name);

                    $images .= (($key + 1) != $total_image) ? $file_name . "##" : $file_name;
                }
                $vehicle_data['images'] = $images;
            } else {
                $vehicle_data['images'] = 'default.png';
            }


            $isSave = DB::table((new VehicleSetup())->getTable())->insert($vehicle_data);


            return response()->json([
                "status" => $isSave ? "success" : "error",
                "title" => $isSave ? "সফল" : "ব্যর্থ",
                "message" => $isSave ? "সফলভাবে নতুন যানবাহন রেজিস্ট্রেশন সফল হয়েছে" : "কোন সমস্যা আছে"
            ]);


        } else {
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "কোন সমস্যা আছে",
                "errors" => $validate->errors()
            ]);
        }


    }


    public function update(Request $request)
    {
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
            GlobalHelper::getOrganizationCode())->whereNull('deleted_at')], function ($input) {

            $isExist = VehicleSetup::where('org_code', GlobalHelper::getOrganizationCode())->where('vehicle_reg_no',
                $input->vehicle_reg_no)->where('id', '!=', $input->row_id)->first();

            return !empty($isExist) ? true : false;
        });

        if (!$validate->fails()) {

            $vehicle_data = [
                "org_code" => GlobalHelper::getOrganizationCode(),
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


            return response()->json([
                "status" => $isUpdate ? "success" : "error",
                "title" => $isUpdate ? "সফল" : "ব্যর্থ",
                "message" => $isUpdate ? "সফলভাবে যানবাহনের তথ্য আপডেট  সফল হয়েছে" : "কোন সমস্যা আছে"
            ]);


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


        // check vehicle exists log_books table
        $isExists = DB::table((new LogBook())->getTable())->where('vehicle_id', $request->row_id)->whereNull('deleted_at')->count() ?? 0;

        if ($isExists > 0) {
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "ইতিমধ্যে আপনি এই  যানবাহনের নং লগ বইতে ব্যবহার করেছেন"
            ]);
        } else {
            $isDelete = VehicleSetup::find($request->row_id)->delete();

            return response()->json([
                "status" => $isDelete ? "success" : "error",
                "title" => $isDelete ? "সফল" : "ব্যর্থ",
                "message" => $isDelete ? "সফলভাবে মুছে ফেলা হয়েছে" : "ব্যর্থ হয়েছেন"
            ]);
        }

    }

    public function uselessVehicle()
    {
        return view('useless_vehicle');
    }

    public function uselessVehicleList()
    {
        $data = VehicleSetup::list_data(0);
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function uselessVehicleStore(Request $request)
    {

        $isUpdate = DB::table((new VehicleSetup())->getTable())->where("id", $request->vehicle_id)->update([
            "useless_date" => $request->useless_date,
            "updated_at" => Carbon::now(),
            "status" => 0 // 0 = useless
        ]);

        return response()->json([
            "status" => $isUpdate ? "success" : "error",
            "title" => $isUpdate ? "সফল" : "ব্যর্থ",
            "message" => $isUpdate ? "সফলভাবে যানবাহনটি অকেজো তালিকায় যোগ হয়েছে" : "কোন সমস্যা আছে"
        ]);

    }


}

?>
