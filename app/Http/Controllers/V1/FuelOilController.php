<?php

namespace App\Http\Controllers\V1;

use App\helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\V1\FuelOil;
use App\Models\V1\VehicleSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;
use Yajra\DataTables\Facades\DataTables;

class FuelOilController extends Controller
{

    private $type = ['প্রেক্টল','ডিজেল','অকটেন','ইঞ্জিন অয়েল','গিয়ার অয়েল','গ্রীজ','পাওয়ার অয়েল','হাইড্রলীক অয়েল','ব্রেক অয়েল',];

    public function index()
    {
        $vehicle_setup = VehicleSetup::with('driver_info')->where('org_code', GlobalHelper::getOrganizationCode())->whereNull('deleted_at')->get();

        return view('lobriant',compact('vehicle_setup'));
    }

    public function list_data()
    {
        $data = FuelOil::list_data();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('lobriant_type',function ($row){
                return $this->type[$row->type -1];
            })
            ->addColumn('insert_data',function ($row){
                return date('d-m-Y',strtotime($row->created_at));
            })
            ->make(true);
    }

    public function store(Request $request){

        $validate = Validator::make($request->all(),[
                'vehicle_id'=> 'required',
                'type'=> 'required',
                'in_litter'=> 'required',
                'payment'=> 'required',
            ],[

            'vehicle_id.required'=> 'গাড়িং নং নির্বাচন করুন',
            'type.required'=> 'লুব্রিক্যান্ট টাইপ প্রদান করুন',
            'in_litter.required'=> 'লিটারে প্রদান করুন',
            'payment.required'=> 'টাকা প্রদান করুন',
        ]);

        if (!$validate->fails()){

//                $lubricant_data=[
//                    'org_code'=> GlobalHelper::getOrganizationCode(),
//                    'vehicle_id'=> $request->vehicle_id,
//                    'type'=> $request['type'],
//                    'in'=> $request['in_litter'],
//                    'payment'=> $request['payment'],
//                ];
//                    $org_code = GlobalHelper::getOrganizationCode();
//                    $vehicle_id= $request->vehicle_id;
                    $type= $request->type;
                    $in = $request->in_litter;
                    $payment = $request->payment;

                    for($count = 0; $count < count($type); $count++)
                    {
                        $lubricant_data=[
                            'org_code'=> GlobalHelper::getOrganizationCode(),
                            'vehicle_id'=> $request->vehicle_id,
                            'type'=> $type[$count],
                            'in'=> $in[$count],
                            'payment'=> $payment[$count],
                            "created_at"=>Carbon::now()
                        ];
                        $insert_data[] = $lubricant_data;
                    }


            $isSave = DB::table('fuel_oil')->insert($insert_data);



            if ($isSave == true){
                return response()->json([
                   "status" => $isSave ? "success":"error",
                   "title" => $isSave ? "সফল" : "ব্যর্থ",
                    "message" => $isSave ? "সফলভাবে লুব্রিকেন্ট যুক্ত হয়েছে" : "কোন সমস্যা আছে"
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


}

?>
