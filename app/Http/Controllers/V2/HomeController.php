<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\V2\Route;
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
}
