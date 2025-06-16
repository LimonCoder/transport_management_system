<?php

namespace App\Http\Controllers;

use App\helpers\GlobalHelper;
use App\Models\DriverInfo;
use App\Models\Employee;
use App\Models\FuelOil;
use App\Models\OrganizationInfo;
use App\Models\Repairs;
use App\Models\VehicleSetup;
use Illuminate\Http\Request;
use Rakibhstu\Banglanumber\NumberToBangla;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orgCode = GlobalHelper::getOrganizationCode();

        $data = [
            'total_vehicle' => VehicleSetup::where('org_code', $orgCode)->whereNull('deleted_at')->count(),
            'useless_total_vehicle' => VehicleSetup::where('org_code', $orgCode)->whereNull('deleted_at')->where('status', 0)->count(),
            'total_employee' => Employee::where('org_code', $orgCode)->whereNull('deleted_at')->count(),
            'total_driver' => DriverInfo::where('org_code', $orgCode)->whereNull('deleted_at')->count(),
            'repairs_total_cost' => Repairs::where('org_code', $orgCode)->whereNull('deleted_at')->sum('total_cost'),
            'lubricant_total_cost' => FuelOil::where('org_code', $orgCode)->whereNull('deleted_at')->sum('payment'),
            'total_org'    => OrganizationInfo::whereNull('deleted_at')->count(),
            'grand_total_vehicle' => VehicleSetup::whereNull('deleted_at')->count(),
            'grand_useless_total_vehicle' => VehicleSetup::whereNull('deleted_at')->where('status', 0)->count(),
            'grand_total_driver' => DriverInfo::whereNull('deleted_at')->count(),
            'bnConverter' => new NumberToBangla()
        ];



        return view('deshboard', $data);
    }
}
