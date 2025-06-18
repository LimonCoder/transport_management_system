<?php

namespace App\Http\Controllers\Api\V1;

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

class EmployeeController extends Controller
{

    public function index()
    {
        $designations = Designation::whereNull('deleted_at')->get();
        return response()->json([
            "status" => $designations ? "success" : "error",
            "message" => $designations ? "designation data found " : "designation data not found",
            "data" => $designations ? $designations : []
        ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'employee_name' => 'required',
            'designation_id' => ['required', 'numeric'],
            'username' => ['required', Rule::unique('users', 'username')->whereNull('deleted_at')],
            'password' => 'required',

        ], [
            "employee_name.required" => "কর্মকর্তার নাম প্রদান করুন",
            "designation_id.required" => "পদবী নির্বাচন করুন",
            "username.required" => "ইউজারনেম প্রদান করুন",
            "username.unique" => "এই ইউজারনেম পূর্বে ব্যবহার করা হয়েছে",
            "password.required" => "পাসওয়ার্ড প্রদান করুন",
        ]);

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {

                $employee_data = [
                    "org_code" => $request->org_code,
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
                    "org_code" => $request->org_code,
                    "employee_id" => $employee_id,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "type" => 3, // 3 = others
                    "created_at" => Carbon::now()

                ]);

                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "message" => "Employee save success"
                ])->setStatusCode(200);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    "status" => "error",
                    "message" => "Something went wrong",
                    "error" => $e->getMessage()
                ])->setStatusCode(500);
            }
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong",
                "errors" => $validate->errors()
            ])->setStatusCode(402);
        }
    }


    public function list_data(Request $request)
    {

        $org_code = $request->org_code;

        $data = DB::table('employees AS EMP')
            ->Join('users AS USG', function ($join) use ($org_code) {
                $join->on('EMP.org_code', '=', 'EMP.org_code')
                    ->on('USG.employee_id', '=', 'EMP.id')
                    ->where('USG.org_code', $org_code)
                    ->where('EMP.org_code', $org_code)
                    ->whereNull('USG.deleted_at')
                    ->whereNull('EMP.deleted_at');
            })
            ->Join('designation AS DEG', function ($join) {
                $join->on('DEG.id', '=', 'EMP.designation_id')
                    ->whereNull('EMP.deleted_at')
                    ->whereNull('DEG.deleted_at');
            })
            ->where('EMP.org_code', $org_code)
            ->where('USG.type', 3)
            ->whereNull('EMP.deleted_at')
            ->select('EMP.id', 'EMP.name AS employee_name', 'EMP.mobile_no', 'EMP.email', 'EMP.image', 'DEG.id AS designation_id', 'DEG.name AS designation_name', 'USG.id AS user_id', 'USG.username', 'USG.type')
            ->get();
        return response()->json([
            "status" => $data ? "success" : "error",
            "message" => $data ? "Employee data found" : "Employee data not found",
            "data" => $data ? $data : []
        ]);
    }

    public function update(Request $request)
    {
        $org_code = $request->org_code;

        $validate = Validator::make($request->all(), [
            'employee_name' => 'required',
            'designation_id' => ['required', 'numeric']

        ],
            [
                "employee_name.required" => "কর্মকর্তার নাম প্রদান করুন",
                "designation_id.required" => "পদবী নির্বাচন করুন",
                "username.required" => "ইউজারনেম প্রদান করুন",
                "username.unique" => "এই ইউজারনেম পূর্বে ব্যবহার করা হয়েছে",
            ]);


        $validate->sometimes('username', [Rule::unique('users', 'username')->whereNull('deleted_at')], function ($input) use ($org_code) {
            $isExist = User::where('org_code', $org_code)->where('username',
                $input->username)->where('id', '!=', $input->user_id)->first();

            return !empty($isExist) ? true : false;
        });

        if (!$validate->fails()) {
            DB::beginTransaction();
            try {

                $employee_data = [
                    "org_code" => $org_code,
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

                $user_data = [
                    "org_code" => $org_code,
                    "username" => $request->username,
                    "type" => 3, // 3 = others
                    "updated_at" => Carbon::now()

                ];

                if (!empty($request->password)){
                    $user_data['password'] = Hash::make($request->password);
                }

                //user data update
                DB::table('users')->where('id', $request->user_id)->update($user_data);

                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "message" => "Employe update success"
                ])->setStatusCode(200);

            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    "status" => "error",
                    "message" => "Something went rong",
                    "error" => $e->getMessage()
                ])->setStatusCode(401);
            }
        } else {
            return response()->json([
                "status" => "error",
                "message" => "Something went rong",
                "errors" => $validate->errors()
            ])->setStatusCode(401);
        }
    }


    public function destroy(Request $request)
    {

        $org_code = $request->org_code;

        DB::beginTransaction();
        try {

            // check employee_id exists vehicle_setup table
            $isExists = DB::table((new VehicleSetup())->getTable())->where('employee_id', $request->employee_id)
                    ->where('org_code',$org_code)->whereNull('deleted_at')->count() ?? 0;

            if ($isExists > 0) {
                return response()->json([
                    "status" => "error",
                    "message" => "You have already used this officer for car registration"
                ])->setStatusCode(401);

            } else {
                Employee::find($request->employee_id)->delete();
                User::find($request->user_id)->delete();
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "message" => "Employee delete success"
                ])->setStatusCode(200);
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "message" => "Something went rong",
            ]);
        }

    }
}
