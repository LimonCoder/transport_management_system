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
        $orgCode = 0;

        $data = [
            'total_vehicle' => 0,
            'useless_total_vehicle' => 0,
            'total_employee' => 0,
            'total_driver' => 0,
            'repairs_total_cost' => 0,
            'lubricant_total_cost' => 0,
            'total_org'    => 0,
            'grand_total_vehicle' => 0,
            'grand_useless_total_vehicle' => 0,
            'grand_total_driver' => 0,
            'bnConverter' => new NumberToBangla()
        ];



        return view('deshboard', $data);
    }
}
