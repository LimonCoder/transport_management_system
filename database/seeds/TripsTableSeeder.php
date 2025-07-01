<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trips')->insert([
            [
                'org_code' => 1001,
                'route_id' => 1,
                'route_name' => "Route A",
                'driver_id' => 2,
                'driver_name' => 'Ahmed Hassan',
                'vehicle_id' => 1,
                'vehicle_registration_number' => 'DHK-METRO-1234',
                'start_location' => 'Dhaka Office',
                'destination' => 'Chittagong Branch',
                'start_time' => Carbon::now()->setHour(1)->setMinute(0),
                'end_time' => Carbon::now(),
                'distance_km' => 264.50,
                'purpose' => 'Official Meeting',
                'fuel_cost' => 3500.00,
                'total_cost' => 4200.00,
                'is_locked' => 1,
                'trip_initiate_date' => Carbon::now()->setHour(1)->setMinute(0)->format('Y-m-d'),
                'status' => 'completed',
                'reject_reason' => null,
                'created_at' => Carbon::now()->setHour(1)->setMinute(0),
                'created_by' => 4,
                'updated_at' => Carbon::now(),
                'updated_by' => 4,
            ],
            [
                'org_code' => 1001,
                'route_id' => 1,
                'route_name' => 'Route A',
                'driver_id' => 2,
                'driver_name' => 'Ahmed Hassan',
                'vehicle_id' => 1,
                'vehicle_registration_number' => 'DHK-GA-5678',
                'start_location' => 'Head Office',
                'destination' => 'Sylhet Office',
                'start_time' => Carbon::now()->setHour(1)->setMinute(0),
                'end_time' => null,
                'distance_km' => null,
                'purpose' => 'Document Delivery',
                'fuel_cost' => 0.00,
                'total_cost' => 0.00,
                'is_locked' => 0,
                'trip_initiate_date' => Carbon::now()->setHour(1)->setMinute(0)->format('Y-m-d'),
                'status' => 'initiate',
                'reject_reason' => null,
                'created_at' => Carbon::now()->setHour(1)->setMinute(0),
                'created_by' => 5,
                'updated_at' => Carbon::now(),
                'updated_by' => null,
            ],
            [
                'org_code' => 1002,
                'route_id' => 1,
                'route_name' => 'Route A',
                'driver_id' => 1,
                'driver_name' => 'Ahmed Hassan',
                'vehicle_id' => 1,
                'vehicle_registration_number' => 'SYL-KA-2468',
                'start_location' => 'Sylhet Office',
                'destination' => 'Rajshahi Branch',
                // start time current date some previous time
                'start_time' => Carbon::now()->setHour(1)->setMinute(0),
                'end_time' => Carbon::now(),
                'distance_km' => 189.20,
                'purpose' => 'Equipment Transport',
                'fuel_cost' => 2800.00,
                'total_cost' => 3200.00,
                'is_locked' => 1,
                'trip_initiate_date' => Carbon::now()->setHour(1)->setMinute(0)->format('Y-m-d'),
                'status' => 'completed',
                'reject_reason' => null,
                'created_at' => Carbon::now()->setHour(1)->setMinute(0),
                'created_by' => 6,
                'updated_at' => Carbon::now(),
                'updated_by' => 6,
            ],
            [
                'org_code' => 1001,
                'route_id' => 1,
                'route_name' => 'Route A',
                'driver_id' => 1,
                'driver_name' => 'Ahmed Hassan',
                'vehicle_id' => 1,
                'vehicle_registration_number' => 'CHT-HA-9101',
                'start_location' => 'Chittagong Port',
                'destination' => 'Dhaka Office',
                'start_time' => Carbon::now()->setHour(1)->setMinute(0),
                'end_time' => null,
                'distance_km' => null,
                'purpose' => 'Cargo Pickup',
                'fuel_cost' => 0.00,
                'total_cost' => 0.00,
                'is_locked' => 0,
                'trip_initiate_date' => Carbon::now()->setHour(1)->setMinute(0)->format('Y-m-d'),
                'status' => 'reject',
                'reject_reason' => 'Vehicle maintenance required',
                'created_at' => Carbon::now()->setHour(1)->setMinute(0),
                'created_by' => 4,
                'updated_at' => Carbon::now(),
                'updated_by' => 2,
            ],
        ]);
    }
} 