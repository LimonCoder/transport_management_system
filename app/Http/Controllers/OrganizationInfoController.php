<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Employee;
use App\Models\OrganizationInfo;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OrganizationInfoController extends Controller
{

    protected $org_type = ['জেলা প্রশাসক', 'পৌরসভা', 'উপজেলা'];


    public function index()
    {
        $designations = Designation::whereNull('deleted_at')->get();

        return view('organization')->with('designations',$designations);
    }

    public function list_data()
    {
        $data = OrganizationInfo::list_data();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('org_type_name', function ($row) {
                return $this->org_type[$row->org_type - 1];
            })
            ->make(true);
    }


    public function store(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'org_name' => 'required',
            'org_code' => ['required', Rule::unique('organization_info', 'org_code')->whereNull('deleted_at')],
            'org_type' => ['required', 'numeric'],
            'employee_name' => 'required',
            'designation_id' => ['required', 'numeric'],
            'username' => ['required', Rule::unique('users', 'username')->whereNull('deleted_at')],
            'password' => 'required',

        ],
            [
                "org_name.required" => "অফিসের নাম প্রদান করুন",
                "org_code.required" => "অফিসের কোড প্রদান করুন",
                "org_code.unique" => "এই কোড পূর্বে ব্যবহার করা হয়েছে",
                "org_type.required" => "অফিসের ধরণ নির্বাচন করুন",
                "employee_name.required" => "কর্মকর্তার নাম প্রদান করুন",
                "designation_id.required" => "পদবী নির্বাচন করুন",
                "username.required" => "ইউজারনেম প্রদান করুন",
                "username.unique" => "এই ইউজারনেম পূর্বে ব্যবহার করা হয়েছে",
                "password.required" => "পাসওয়ার্ড প্রদান করুন",
            ]);


        if (!$validate->fails()) {
            DB::beginTransaction();
            try {

                // organization data store
                DB::table('organization_info')->insert([
                    "name" => $request->org_name,
                    "org_code" => $request->org_code,
                    "address" => $request->org_address,
                    "org_type" => $request->org_type,
                    "created_at" => Carbon::now()
                ]);

                // employee data store
                $employee_id = DB::table('employees')->insertGetId([
                    "org_code" => $request->org_code,
                    "designation_id" => $request->designation_id,
                    "name" => $request->employee_name,
                    "mobile_no" => $request->mobile_no,
                    "email" => null,
                    "image" => null,
                    "created_at" => Carbon::now()
                ]);

                //user data store
                DB::table('users')->insert([
                    "org_code" => $request->org_code,
                    "employee_id" => $employee_id,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "type" => 2, // 2 = admin
                    "created_at" => Carbon::now()

                ]);

                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "title" => "সফল",
                    "message" => "সফলভাবে নতুন অফিস তৈরী হয়েছে"
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
            'org_name' => 'required',
            'org_code' => ['required', Rule::unique('organization_info', 'org_code')->ignore($request->org_code, 'org_code')
                ->whereNull('deleted_at')],
            'org_type' => ['required', 'numeric'],
            'employee_name' => 'required',
            'designation_id' => ['required', 'numeric'],
            'username' => ['required', Rule::unique('users', 'username')->ignore($request->username, 'username')
                ->whereNull('deleted_at')],
            'password' => 'required',

        ],
            [
                "org_name.required" => "অফিসের নাম প্রদান করুন",
                "org_code.required" => "অফিসের কোড প্রদান করুন",
                "org_code.unique" => "এই কোড পূর্বে ব্যবহার করা হয়েছে",
                "org_type.required" => "অফিসের ধরণ নির্বাচন করুন",
                "employee_name.required" => "কর্মকর্তার নাম প্রদান করুন",
                "designation_id.required" => "পদবী নির্বাচন করুন",
                "username.required" => "ইউজারনেম প্রদান করুন",
                "username.unique" => "এই ইউজারনেম পূর্বে ব্যবহার করা হয়েছে",
                "password.required" => "পাসওয়ার্ড প্রদান করুন",
            ]);


        if (!$validate->fails()) {
            DB::beginTransaction();
            try {

                // organization data update
                DB::table('organization_info')->where('id', $request->org_id)->update(["name" => $request->org_name,
                    "org_code" => $request->org_code,
                    "address" => $request->org_address,
                    "org_type" => $request->org_type,
                    "updated_at" => Carbon::now()
                ]);

                // employee data update
                DB::table('employees')->where('id', $request->employee_id)->update([
                    "org_code" => $request->org_code,
                    "designation_id" => $request->designation_id,
                    "name" => $request->employee_name,
                    "mobile_no" => $request->mobile_no,
                    "email" => null,
                    "image" => null,
                    "updated_at" => Carbon::now()
                ]);

                //user data update
                DB::table('users')->where('id', $request->user_id)->update([
                    "org_code" => $request->org_code,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "type" => 2, // 2 = admin
                    "updated_at" => Carbon::now()
                ]);

                // all right
                DB::commit();
                return response()->json([
                    "status" => "success",
                    "title" => "সফল",
                    "message" => "সফলভাবে  অফিস আপডেট হয়েছে"
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
            OrganizationInfo::find($request->org_id)->delete();
            Employee::find($request->employee_id)->delete();
            User::find($request->user_id)->delete();

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

}

?>
