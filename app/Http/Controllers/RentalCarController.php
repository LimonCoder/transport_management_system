<?php

namespace App\Http\Controllers;

use App\helpers\GlobalHelper;
use App\Models\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RentalCar;
use http\Env\Response;
use phpDocumentor\Reflection\Types\True_;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RentalCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $vehicle_setup = VehicleSetup::with('driver_info')->where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();

        return view('rentalcar',compact('vehicle_setup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_data()
    {
        $data = RentalCar::list_data();
        return DataTables::of($data)
            ->addIndexcolumn()
            ->make(true);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                "vehicle_id"=>'required',
                "from_date"=>'required',
                "to_date"=>'required',
                "amount"=>'required',
            ],

            [
                "vehicle_id.required"=>"গাড়ির নং প্রদান করুন",
                "from_date.required"=>"তারিখ প্রদান করুন",
                "to_date.required"=>"তারিখ প্রদান করুন",
                "amount.required"=>"টাকার পরিমান প্রধান করুন",
            ]);
        if (!$validate->fails()){
            $rentalcar_data = [
                "org_code"=> GlobalHelper::getOrganizationCode(),
                "vehicle_id"=>$request->vehicle_id,
                "from_date"=>$request->from_date,
                "to_date"=>$request->to_date,
                "total_day"=>$request->total_day,
                "amount"=>$request->amount,
                "vat"=>$request->vat,
                "total_amount"=>$request->total_amount,
                "income_tax"=>$request->income_tax,
                "contractor_name"=> $request->contractor_name,
                "address"=> $request->address,
                "insert_date" => date('Y-m-d'),
                "created_at"=>Carbon::now()
            ];

//            dd($rentalcar_data);
            $isSave = DB::table('rental_car')->insert($rentalcar_data);

            if ($isSave == true){
                return response()->json([
                    "status"=> $isSave ? "success":"error",
                    "title"=> $isSave ? "সফল":"ব্যর্থ",
                    "message"=> $isSave ? "সফলভাবে যুক্ত হয়েছে": "কোন সমস্যা আছে"
                ]) ;
            }else{
                return response()->json([
                    "status"=> "error",
                    "title"=> "ব্যর্থ",
                    "message"=> "োন সমস্যা আছে",
                    "error"=> $validate->errors()
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                "vehicle_id"=>'required',
                "from_date"=>'required',
                "to_date"=>'required',
                "amount"=>'required',
            ],

            [
                "vehicle_id.required"=>"গাড়ির নং প্রদান করুন",
                "from_date.required"=>"তারিখ প্রদান করুন",
                "to_date.required"=>"তারিখ প্রদান করুন",
                "amount.required"=>"টাকার পরিমান প্রধান করুন",
            ]);
        if (!$validate->fails()){
            $rentalcar_data = [
                "org_code"=> GlobalHelper::getOrganizationCode(),
                "vehicle_id"=>$request->vehicle_id,
                "from_date"=>$request->from_date,
                "to_date"=>$request->to_date,
                "total_day"=>$request->total_day,
                "amount"=>$request->amount,
                "vat"=>$request->vat,
                "total_amount"=>$request->total_amount,
                "income_tax"=>$request->income_tax,
                "contractor_name"=> $request->contractor_name,
                "address"=> $request->address,
                "insert_date" => date('Y-m-d'),
                "updated_at"=>Carbon::now()
            ];

//            dd($rentalcar_data);
            $isUpdate = DB::table('rental_car')->where("id",$request->row_id)->update($rentalcar_data);

            if ($isUpdate == true){
                return response()->json([
                    "status"=> $isUpdate ? "success":"error",
                    "title"=> $isUpdate ? "সফল":"ব্যর্থ",
                    "message"=> $isUpdate ? "সফলভাবে আপডেট হয়েছে": "কোন সমস্যা আছে"
                ]) ;
            }else{
                return response()->json([
                    "status"=> "error",
                    "title"=> "ব্যর্থ",
                    "message"=> "োন সমস্যা আছে",
                    "error"=> $validate->errors()
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $isDelete = DB::table('rental_car')->where('id',$request->row_id)->delete();

        return response()->json([
            "status" => $isDelete ? "success" : "error",
            "title" => $isDelete ? "সফল" : "ব্যর্থ",
            "message" => $isDelete ? "সফলভাবে মুছে ফেলা হয়েছে" : "ব্যর্থ হয়েছেন"
        ]);
    }
}
