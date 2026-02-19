<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\V2\Route;
use App\Models\V2\VehicleSetup;
use App\Models\V2\Notice;
use App\Models\V2\Trip;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $routes = Route::all(); 
        $today = Carbon::now('Asia/Dhaka')->toDateString();
        $trips = Trip::whereDate('trip_initiate_date', $today)->get();
        $orgs = DB::table('organizations')->first();
        return view('welcome', compact('routes', 'trips', 'orgs'));
    }

    public function getVehicles()
    {
        $routes = VehicleSetup::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'data get successfully',
            'data'    => $routes,
        ]);
    }

    public function getRoutes()
    {
        $routes = Route::all();

        return response()->json([
            'status'  => 'success',
            'message' => __('message.data_get_successfully'),
            'data'    => $routes,
        ]);
    }

    public function getTrips()
    {
        $today = Carbon::now('Asia/Dhaka')->toDateString();
        $trips = Trip::whereDate('trip_initiate_date', $today)->get();

        return response()->json([
            'status'  => 'success',
            'message' => __('message.data_get_successfully'),
            'data'    => $trips,
        ]);
    }

    public function getOrganizations()
    {
        $org = DB::table('organizations')->first();

        return response()->json([
            'status'  => 'success',
            'message' => __('message.data_get_successfully'),
            'data'    => $org,
        ]);
    }

    public function getNotices()
    {
        $notices = Notice::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'data get successfully',
            'data'    => $notices,
        ]);
    }
}
