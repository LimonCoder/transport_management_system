<?php

namespace App\Http\Controllers\V1;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\V1\Employee;
use App\Models\V1\Repairs;
use App\Models\V1\VehicleSetup;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RepairsController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      $employees = Employee::with('designation')->where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();

      $vehicle_setup = VehicleSetup::with('driver_info')->where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();



//     foreach($vehicle_setup as $item){
//         echo "<pre>";
//
//         echo "<pre>";
//         exit;
//     }



      return view('repairs',compact('employees', 'vehicle_setup'));
  }

  public function list_data()
    {
        $data = Repairs::list_data();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

    }

  public function store(Request $request)
  {
        $validate = Validator::make($request->all(),
            [
                'vehicle_id' => ['required', 'numeric'],
                'employee_id' => ['required', 'numeric'],
            ],
            [
                "vehicle_id.required" => "গাড়ির নং প্রদান করুন",
                "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
            ]);

        if (!$validate->fails()){
            $repairs_data = [
                "org_code" => GlobalHelper::getOrganizationCode(),
                "vehicle_id"=>$request->vehicle_id,
                "employee_id"=>$request->employee_id,
                "damage_parts"=>$request->damage_parts,
                "new_parts"=>$request->new_parts,
                "total_cost"=>$request->total_cost,
                "shop_name"=>$request->shop_name,
                "cause_of_problems"=>$request->cause_of_problems,
                "insert_date" => $request->insert_date,
                "created_at"=>Carbon::now()

            ];

            $isSave = DB::table((new Repairs())->getTable())->insert($repairs_data);

            if ($isSave == true){
                return response()->json([
                    "status"=> $isSave ? "success":"error",
                    "title"=> $isSave ? "সফল":"ব্যর্থ",
                    "message" => $isSave ? "সফলভাবে যন্ত্রাংশ যুক্ত হয়েছে" : "কোন সমস্যা আছে"
                ]);
            }else{
                return response()->json([
                    "status" => "error",
                    "title" => "ব্যর্থ",
                    "message" => "কোন সমস্যা আছে",
                    "errors" => $validate->errors()
                ]);
            }
        }
  }

  public function update(Request $request)
  {
      $validate = Validator::make($request->all(), [
          'vehicle_id' => ['required', 'numeric'],
          'employee_id' => ['required', 'numeric'],
      ],
          [
              "vehicle_id.required" => "গাড়ির নং প্রদান করুন",
              "employee_id.required" => "কর্মকর্তার নাম প্রদান করুন",
          ]);

      if (!$validate->fails()){
          $repairs_data = [
              "org_code" => GlobalHelper::getOrganizationCode(),
              "vehicle_id"=>$request->vehicle_id,
              "employee_id"=>$request->employee_id,
              "damage_parts"=>$request->damage_parts,
              "new_parts"=>$request->new_parts,
              "total_cost"=>$request->total_cost,
              "shop_name"=>$request->shop_name,
              "cause_of_problems"=>$request->cause_of_problems,
              "insert_date" => $request->insert_date,
              "updated_at"=>Carbon::now()
          ];

          $isUpdate = DB::table((new Repairs())->getTable())->where('id',$request->row_id)->update($repairs_data);

          if ($isUpdate == true){
              return response()->json([
                  "status"=> $isUpdate ? "success":"error",
                  "title"=> $isUpdate ? "সফল":"ব্যর্থ",
                  "message" => $isUpdate ? "সফলভাবে যন্ত্রাংশ আপডেট হয়েছে" : "কোন সমস্যা আছে"
              ]);
          }else{
              return response()->json([
                  "status" => "error",
                  "title" => "ব্যর্থ",
                  "message" => "কোন সমস্যা আছে",
                  "errors" => $validate->errors()
              ]);
          }
      }
  }

  public function destroy(Request $request)
  {
      $isDelete = Repairs::find($request->row_id)->delete();

          return response()->json([
              "status" => $isDelete ? "success" : "error",
              "title" => $isDelete ? "সফল" : "ব্যর্থ",
              "message" => $isDelete ? "সফলভাবে মুছে ফেলা হয়েছে" : "ব্যর্থ হয়েছেন"
          ]);
  }

}

?>
