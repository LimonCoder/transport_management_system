<?php

namespace App\Http\Controllers\V1;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\V1\Designation;
use App\Models\V1\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{

    public function index()
    {
        return view('designation');
    }


    public function list_data()
    {
        $data = Designation::where('org_code',GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required'
        ], [
            "name.required" => "পদবী প্রদান করুন",
        ]);

        if (!$validate->fails()) {

            $operation = '';
            $designation_data = [];

            $designation_data = [
                "org_code" => GlobalHelper::getOrganizationCode(),
                "name" => $request->name,
            ];

            if (!empty($request->row_id)) {
                $operation = 'আপডেট';
                $designation_data['updated_at'] = Carbon::now();

                $response = Designation::where('id', $request->row_id)->update($designation_data);

            } else {
                $operation = 'যোগ';
                $designation_data['created_at'] = Carbon::now();
                $response = Designation::create($designation_data);
            }

            return response()->json([
                "status" => $response ? "success" : "error",
                "title" => $response ? "সফল" : "ব্যর্থ",
                "message" => $response ? "সফলভাবে $operation হয়েছে" : "ব্যর্থ হয়েছেন"
            ]);
        } else {
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "ব্যর্থ হয়েছেন",
                "errors" => $validate->errors()
            ]);
        }


    }


    public function destroy(Request $request)
    {
        // check designation exists employee table
        $isExists = DB::table((new Employee())->getTable())->where('designation_id', $request->row_id)->whereNull('deleted_at')->count() ?? 0;

        if ($isExists > 0) {
            return response()->json([
                "status" => "error",
                "title" => "ব্যর্থ",
                "message" => "ইতিমধ্যে আপনি এই পদবী ব্যবহার করেছেন"
            ]);
        } else {
            $isDelete = Designation::find($request->row_id)->delete();

            return response()->json([
                "status" => $isDelete ? "success" : "error",
                "title" => $isDelete ? "সফল" : "ব্যর্থ",
                "message" => $isDelete ? "সফলভাবে মুছে ফেলা হয়েছে" : "ব্যর্থ হয়েছেন"
            ]);
        }


    }
}
