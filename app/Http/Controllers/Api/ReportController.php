<?php

namespace App\Http\Controllers\Api;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\VehicleSetup;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReportController extends Controller
{

//employee report
    public function employee_report(Request $request){

        $org_code = $request->org_code;

        $data_url = env('APP_URL').'/report/employee/'.$org_code;


        return response()->json([
            "status"=> "success",
            "data_url"=> $data_url
        ]);
    }

//driver Report

    public function driver_report(Request $request)
    {
        $org_code = $request->org_code;

        $data_url = env('APP_URL').'/report/driver/'.$org_code;


        return response()->json([
            "status"=> "success",
            "data_url"=> $data_url
        ]);
    }
//repairs report

//    public function repairs(Request $request){
//
//        $data = VehicleSetup::list_data();
//
//        $statusCode = $data ? 200 : 401;
//
//        return response()->json([
//            "status"=> $data ? "success" : "error",
//            "massage"=> $data ? "vehicle_reg_no data found" : "vehicle_reg_no data not found",
//            "data"=> $data ? $data:[]
//        ])->setStatusCode($statusCode);
//
//
//    }

    public function repairs_report_print(Request $request)
    {

        $vehicle_reg_no = $request->vehicle_reg_no;
        $from = $request->from_date;
        $to= $request->to_date;
        $org_code = $request->org_code;



        $data_url = env('APP_URL').'/report/repairs_report_print?'.'vehicle_reg_no='.$vehicle_reg_no.'&'.'from_date='.$from.'&'.'to_date='.$to.'&'.'org_code='.$org_code;


        return response()->json([
            "status"=> "success",
            "data_url"=> $data_url
        ]);

    }

    //lubricant report

    public function lubricant_report_print(Request $request){
        $vehicle_reg_no = $request->vehicle_reg_no;
        $from = $request->from_date;
        $to= $request->to_date;
        $org_code = $request->org_code;

      //  dd($request->all());

        $data_url = env('APP_URL').'/report/lubricant_report_print?'.'vehicle_reg_no='.$vehicle_reg_no.'&'.'from_date='.$from.'&'.'to_date='.$to.'&'.'org_code='.$org_code;


        return response()->json([
            "status"=> "success",
            "data_url"=> $data_url
        ]);

    }

    //Useless Report
    public static function useless_report_print(Request $request)
    {
        $from= $request->from_date;
        $to= $request->to_date;
        $org_code = $request->org_code;

        $data_url = env('APP_URL').'/report/useless_report_print/'.$from.'/'.$to.'/'.$org_code;


        return response()->json([
            "status"=> "success",
            "data_url"=> $data_url
        ]);
    }

    //log_book report

    public function log_book_report_print(Request $request)
    {
        $from = $request->from_date;
        $to = $request->to_date;
        $org_code = $request->org_code;

        $data_url = env('APP_URL').'/report/log_book_report_print/'.$from.'/'.$to.'/'.$org_code;


        return response()->json([
            "status"=> "success",
            "data_url"=> $data_url
        ]);
    }

    public function rentalcar_report_print(Request $request){

        $from = $request->from_date;
        $to = $request->to_date;
        $org_code = $request->org_code;

        $data_url = env('APP_URL').'/report/rentalcar_report_print?'.'from_date='.$from.'&'.'to_date='.$to.'&'.'org_code='.$org_code;


        return response()->json([
            "status"=> "success",
            "data_url"=> $data_url
        ]);
    }
}
