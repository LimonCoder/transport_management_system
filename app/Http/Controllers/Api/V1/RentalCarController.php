<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RentalCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $org_code = $request->org_code;
        $data['vehicles'] = VehicleSetup::where('org_code', $org_code)->whereNull('deleted_at')->get();

        return response()->json([
            "status" => "success",
            "message" => "data found",
            "data" => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        if (!$validate->fails()) {

            $rentalcar_data = [
                "org_code" =>  $request->org_code,
                "vehicle_id" => $request->vehicle_id,
                "from_date" => $request->from_date,
                "to_date" => $request->to_date,
                "total_day" => $request->total_day,
                "amount" => $request->amount,
                "vat" => $request->vat,
                "total_amount" => $request->total_amount,
                "income_tax" => $request->income_tax,
                "insert_date" => date('Y-m-d'),
                "created_at" => Carbon::now()
            ];

//            dd($rentalcar_data);
            $response = DB::table('rental_car')->insert($rentalcar_data);

            $statusCode = $response ? 200 : 401;

            return response()->json([
                "status" => $response ? "success" : "error",
                "message" => $response ? "Rental car save success" : "Fail to save. please try again",
            ])->setStatusCode($statusCode);
        }else{
            return response()->json([
                "status" => "error",
                "message" => "Something wrong",
            ])->setStatusCode(401);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list_data(Request $request)
    {
        $org_code = $request->org_code;

        $data = DB::table('rental_car AS RC')
            ->Join('vehicle_setup AS VS',function($join) use($org_code){
                $join->on('VS.id','=','RC.vehicle_id')
                    ->on('VS.org_code','=','RC.org_code')
                    ->whereNull('VS.deleted_at')
                    ->whereNull('RC.deleted_at');
            })
            ->where('RC.org_code',$org_code)
            ->whereNull('RC.deleted_at')
            ->select(DB::raw("RC.*"),'VS.body_type','VS.vehicle_reg_no')
            ->get();

        $statusCode = $data ? 200 :401;

        return response()->json([
            "status" => $data ? "success" : "error",
            "message" => $data ? "Rental car data found" : "Rental car data not found",
            "data" => $data ? $data : [],
        ])->setStatusCode($statusCode);
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
        $org_code = $request->org_code;

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
        if (!$validate->fails()) {
            $rentalcar_data = [
                "org_code" => $org_code,
                "vehicle_id" => $request->vehicle_id,
                "from_date" => $request->from_date,
                "to_date" => $request->to_date,
                "total_day" => $request->total_day,
                "amount" => $request->amount,
                "vat" => $request->vat,
                "total_amount" => $request->total_amount,
                "income_tax" => $request->income_tax,
                "insert_date" => date('Y-m-d'),
                "updated_at" => Carbon::now()
            ];

//            dd($rentalcar_data);
            $isUpdate = DB::table('rental_car')->where("id", $request->row_id)->update($rentalcar_data);

            $statusCode = $isUpdate ? 200 : 401;


            return response()->json([
                "status" => $isUpdate ? "success" : "error",
                "message" => $isUpdate ? "Rental car update success" : "Fail to save.Please try again"
            ])->setStatusCode($statusCode);


        } else {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong",
                "errors" => $validate->errors()
            ])->setStatusCode(401);
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
        $statusCode = $isDelete ? 200 : 401;

        return response()->json([
            "status" => $isDelete ? "success" : "error",
            "message" => $isDelete ? "Rental car delete success" : "Fail to delete.Please try again"
        ])->setStatusCode($statusCode);
    }
}
