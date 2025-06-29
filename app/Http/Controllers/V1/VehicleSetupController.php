<?php

namespace App\Http\Controllers\V1;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\V1\DriverInfo;
use App\Models\V1\Employee;
use App\Models\V1\LogBook;
use App\Models\V1\VehicleSetup;
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
        // $data['employees'] = Employee::where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();
        // $data['drivers'] = DriverInfo::where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();
        return view('vehicle_setup');

    }


        public function list_data()
        {
            $data = DB::table('vehicles')
                ->whereNull('deleted_at')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }


   public function store(Request $request)
{
    try {
        $data = $request->validate([
            'registration_number' => 'required|string|unique:vehicles',
            'model' => 'nullable|string',
            'capacity' => 'nullable|string',
            'fuel_type_id' => 'required|numeric',
            'status' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $image_paths = [];

        // Multiple image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/vehicles', $filename);
                $image_paths[] = 'storage/vehicles/' . $filename;
            }
        }

        // Auth fallback
        $user = auth()->user();
        $data['created_by'] = $user->id ?? 1;
        $data['org_code'] = $user->org_code ?? '1001';

        // Save only first image as picture
        $data['images'] = $image_paths[0] ?? null;

        // Create record
        VehicleSetup::create($data);

        return response()->json([
            'success' => true, 
            'message' => 'Vehicle Added Successfully!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error adding vehicle: ' . $e->getMessage()
        ], 500);
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

            $isDelete = VehicleSetup::find($request->row_id)->delete();

            return response()->json([
                "status" => $isDelete ? "success" : "error",
                "title" => $isDelete ? "সফল" : "ব্যর্থ",
                "message" => $isDelete ? "সফলভাবে মুছে ফেলা হয়েছে" : "ব্যর্থ হয়েছেন"
            ]);


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
