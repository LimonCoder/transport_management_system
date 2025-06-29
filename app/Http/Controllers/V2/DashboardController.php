<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\V2\Organization;
use App\Models\V2\Driver;
use App\Models\V2\Operator;
use App\Models\V2\VehicleSetup;
use App\Models\V2\Trip;
use Illuminate\Support\Facades\Auth;
use Rakibhstu\Banglanumber\NumberToBangla;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userType = $user->user_type;
        $orgCode = $user->org_code;
        
        $data = [
            'bnConverter' => new NumberToBangla()
        ];

        switch ($userType) {
            case 'system-admin':
                $data = array_merge($data, $this->getSystemAdminData());
                break;
                
            case 'operator':
                $data = array_merge($data, $this->getOperatorData($orgCode));
                break;
                
            case 'driver':
                $data = array_merge($data, $this->getDriverData($user->id));
                break;
        }

        return view('deshboard', $data);
    }

    private function getSystemAdminData(): array
    {
        return [
            'total_organizations' => Organization::count(),
            'total_drivers' => Driver::count(),
            'total_operators' => Operator::count(),
            'total_vehicles' => VehicleSetup::count(),
        ];
    }

    private function getOperatorData($orgCode): array
    {
        return [
            'total_drivers_in_org' => Driver::where('org_code', $orgCode)->count(),
            'total_vehicles_in_org' => VehicleSetup::where('org_code', $orgCode)->count(),
            'total_maintenance_vehicles_in_org' => VehicleSetup::where('org_code', $orgCode)
                                                              ->where('status', 'maintenance')
                                                              ->count(),
        ];
    }

    private function getDriverData($userId): array
    {
        // Get driver record to get driver_id
        $driver = Driver::where('user_id', $userId)->first();
        $driverId = $driver ? $driver->id : 0;

        return [
            'total_trips' => Trip::where('driver_id', $driverId)->count(),
            'total_initiate_trips' => Trip::where('driver_id', $driverId)
                                         ->where('status', 'initiate')
                                         ->count(),
            'total_completed_trips' => Trip::where('driver_id', $driverId)
                                          ->where('status', 'completed')
                                          ->count(),
            'total_rejected_trips' => Trip::where('driver_id', $driverId)
                                         ->where('status', 'reject')
                                         ->count(),
        ];
    }
}
