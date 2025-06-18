<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FuelOilController extends Controller
{
    public static function list_data(Request $request)
    {
        $org_code = $request->org_code;
        $data = DB::table('fuel_oil AS FO')
            ->Join('vehicle_setup AS VS', function ($join) {
                $join->on('VS.id', '=', 'FO.vehicle_id')
                    ->on('FO.org_code', '=', 'VS.org_code')
                    ->whereNull('FO.deleted_at')
                    ->whereNull('VS.deleted_at');
            })
            ->where('FO.org_code', $org_code)
            ->select('VS.vehicle_reg_no')
            ->selectRaw("FO.*")
            ->get();

        $statusCode = $data ? 200 : 401;
        return response()->json([
            "status" => $data ? "success" : "error",
            "massage" => $data ? "lubricant data found" : "lubricant data not found",
            "data" => $data ? $data : [],
        ])->setStatusCode($statusCode);
    }

    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'type' => 'required',
            'in_litter' => 'required',
            'payment' => 'required',
        ], [

            'vehicle_id.required' => 'গাড়িং নং নির্বাচন করুন',
            'type.required' => 'লুব্রিক্যান্ট টাইপ প্রদান করুন',
            'in_litter.required' => 'লিটারে প্রদান করুন',
            'payment.required' => 'টাকা প্রদান করুন',
        ]);

        if (!$validate->fails()) {

                $lubricant_data = [
                    'org_code' => $request->org_code,
                    'vehicle_id' => $request->vehicle_id,
                    'type' => $request->type,
                    'in' => $request->in_litter,
                    'payment' => $request->payment,
                    "created_at" => Carbon::now()
                ];

            $response = DB::table('fuel_oil')->insert($lubricant_data);

            $statusCode = $response ? 200 : 401;

            return response()->json([
                "status" => $response ? "success" : "error",
                "message" => $response ? "lubricant save success" : "Fail to save. please try again",
            ])->setStatusCode($statusCode);
        }else{
            return response()->json([
                "status" => "error",
                "message" => "Something wrong",
            ])->setStatusCode(401);
        }
    }
}
