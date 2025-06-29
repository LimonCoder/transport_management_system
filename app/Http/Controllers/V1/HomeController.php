<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
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



        return view('v1.deshboard', $data);
    }
}
