<?php

namespace App\Http\Controllers\V1;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\V1\Designation;
use App\Models\V1\Employee;
use App\Models\V1\User;
use App\Models\V1\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{


    public function index()
    {
        $designations = Designation::whereNull('deleted_at')->get();
        return view('employee')->with('designations', $designations);
    }

    public function list_data()
    {
        $data = Employee::list_data();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'employee_name' => 'required',
            'designation_id' => ['required', 'numeric'],
            'username' => [Rule::unique('users', 'username')->whereNull('deleted_at')],
            // 'password' => 'required',

        ],
            [
                "employee_name.required" => "কর্মকর্তার নাম প্রদান করুন",
                "designation_id.required" => "পদবী নির্বাচন করুন",
                // "username.required" => "ইউজারনেম প্রদান করুন",
                "username.unique" => "এই ইউজারনেম পূর্বে ব্যবহার করা হয়েছে",
                // "password.required" => "পাসওয়ার্ড প্রদান করুন",
            ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {

                $employee_data = [
                    "org_code" => GlobalHelper::getOrganizationCode(),
                    "designation_id" => $request->designation_id,
                    "name" => $request->employee_name,
                    "mobile_no" => $request->mobile_no,
                    "email" => $request->email,
                    "created_at" => Carbon::now()
                ];

                if ($request->hasFile('picture')) {
                    $fileName = '';
                    $file = $request->file('picture');
                    $file_name = Str::random(6) . '' . time() . '.' . $file->getClientOriginalExtension();

                    $file->move(base_path('storage/app/public/employees/'), $file_name);

                    $employee_data['image'] = $file_name;
                } else {
                    $employee_data['image'] = 'default.png';
                }


                // employee data store
                $employee_id = DB::table('employees')->insertGetId($employee_data);

                //user data store
                DB::table('users')->insert([
                    "org_code" => GlobalHelper::getOrganizationCode(),
                    "employee_id" => $employee_id,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "type" => 3, // 3 = others
                    "updated_at" => Carbon::now()

                ]);

                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "title" => "সফল",
                    "message" => "সফলভাবে নতুন কর্মকর্তা তৈরী হয়েছে"
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    "status" => "error",
                    "title" => "ব্যর্থ",
                    "message" => "কোন সমস্যা আছে",
                    "error" => $e->getMessage()
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


    public function update(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'employee_name' => 'required',
            'designation_id' => ['required', 'numeric'],
            // 'password' => 'required',

        ],
            [
                "employee_name.required" => "কর্মকর্তার নাম প্রদান করুন",
                "designation_id.required" => "পদবী নির্বাচন করুন",
                "username.required" => "ইউজারনেম প্রদান করুন",
                // "username.unique" => "এই ইউজারনেম পূর্বে ব্যবহার করা হয়েছে",
                // "password.required" => "পাসওয়ার্ড প্রদান করুন",
            ]);


        $validate->sometimes('username', [Rule::unique('users', 'username')->whereNull('deleted_at')], function ($input) {
            $isExist = User::where('org_code', GlobalHelper::getOrganizationCode())->where('username',
                $input->username)->where('id', '!=', $input->user_id)->first();

            return !empty($isExist) ? true : false;
        });

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {

                $employee_data = [
                    "org_code" => GlobalHelper::getOrganizationCode(),
                    "designation_id" => $request->designation_id,
                    "name" => $request->employee_name,
                    "mobile_no" => $request->mobile_no,
                    "email" => $request->email,
                    "updated_at" => Carbon::now()
                ];

                if ($request->hasFile('picture')) {

                    if ($request->previous_picture != "default.png") {
                        @unlink(base_path('storage/app/public/employees/' . $request->previous_picture));
                    }


                    $fileName = '';
                    $file = $request->file('picture');
                    $file_name = Str::random(6) . '' . time() . '.' . $file->getClientOriginalExtension();

                    $file->move(base_path('storage/app/public/employees/'), $file_name);

                    $employee_data['image'] = $file_name;
                }


                // employee data update
                DB::table('employees')->where('id', $request->employee_id)->update($employee_data);

                //user data update
                DB::table('users')->where('id', $request->user_id)->update([
                    "org_code" => GlobalHelper::getOrganizationCode(),
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "type" => 3, // 3 = others
                    "created_at" => Carbon::now()

                ]);

                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "title" => "সফল",
                    "message" => "সফলভাবে কর্মকর্তার তথ্য আপডেট হয়েছে"
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    "status" => "error",
                    "title" => "ব্যর্থ",
                    "message" => "কোন সমস্যা আছে",
                    "error" => $e->getMessage()
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

            // check employee_id exists vehicle_setup table
            $isExists = DB::table((new VehicleSetup())->getTable())->where('employee_id', $request->employee_id)->whereNull('deleted_at')->count() ?? 0;

            if ($isExists > 0) {
                return response()->json([
                    "status" => "error",
                    "title" => "ব্যর্থ",
                    "message" => "ইতিমধ্যে আপনি এই কর্মকর্তাকে গাড়ি রেজিস্ট্রেশনের জন্য ব্যবহার করেছেন"
                ]);
            } else {
                Employee::find($request->employee_id)->delete();
                User::find($request->user_id)->delete();
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "title" => "সফল",
                    "message" => "সফলভাবে ডিলিট হয়েছে"
                ]);
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "কোন সমস্যা আছে",
            ]);
        }

    }

}

?>
