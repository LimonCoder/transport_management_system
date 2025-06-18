<?php

namespace App\Http\Controllers\V1;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\V1\DriverInfo;
use App\Models\V1\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DriverInfoController extends Controller
{

    public function index()
    {
        return view('driver');
    }


    public function list_data()
    {
        $data = DriverInfo::list_data();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',


        ],
            [
                "name.required" => "কর্মকর্তার নাম প্রদান করুন",
            ]);

        if (!$validate->fails()) {

            $operation_type = '';

            $driver_data = [
                "org_code" => GlobalHelper::getOrganizationCode(),
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

            if (!empty($request->row_id)) {
                $operation_type = "আপডেট";
                $driver_data['updated_at'] = Carbon::now();
                // update
                $response = DriverInfo::where('id', $request->row_id)->update($driver_data);
            } else {
                $operation_type = "যোগ";
                $driver_data['image'] = !empty($file_name) ? $file_name : 'default.png';
                $driver_data['created_at'] = Carbon::now();

                // driver data store
                $response = DriverInfo::create($driver_data);
            }


            return response()->json([
                "status" => $response ? "success" : "error",
                "title" => $response ? "সফল" : "ব্যর্থ",
                "message" => $response ? "সফলভাবে ড্রাইভার $operation_type হয়েছে" : "কোন সমস্যা আছে"
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
        // check driver_data exists vehicle_setup table
        $isExists = DB::table((new VehicleSetup())->getTable())->where('driver_id', $request->row_id)->whereNull('deleted_at')->count() ?? 0;

        if ($isExists > 0) {
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "ইতিমধ্যে আপনি এই ডাইভারকে গাড়ি রেজিস্ট্রেশনের জন্য ব্যবহার করেছেন"
            ]);
        } else {
            $isDelete = DriverInfo::find($request->row_id)->delete();

            return response()->json([
                "status" => $isDelete ? "success" : "error",
                "title" => $isDelete ? "সফল" : "ব্যর্থ",
                "message" => $isDelete ? "সফলভাবে মুছে ফেলা হয়েছে" : "ব্যর্থ হয়েছেন"
            ]);
        }
    }

}

?>
