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
                'driver_id' => 1,
                'driver_name' => 'Ahmed Hassan',
                'vehicle_id' => 1,
                'vehicle_registration_number' => 'DHK-METRO-1234',
                'start_location' => 'Dhaka Office',
                'destination' => 'Chittagong Branch',
                'start_time' => Carbon::now()->subDays(2)->setHour(9)->setMinute(0),
                'end_time' => Carbon::now()->subDays(2)->setHour(15)->setMinute(30),
                'distance_km' => 264.50,
                'purpose' => 'Official Meeting',
                'fuel_cost' => 3500.00,
                'total_cost' => 4200.00,
                'is_locked' => 1,
                'trip_initiate_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'status' => 'completed',
                'reject_reason' => null,
                'created_at' => Carbon::now()->subDays(3),
                'created_by' => 4,
                'updated_at' => Carbon::now()->subDays(2)->setHour(16),
                'updated_by' => 4,
            ],
            [
                'org_code' => 1001,
                'route_id' => 1,
                'route_name' => 'Route A',
                'driver_id' => 1,
                'driver_name' => 'Ahmed Hassan',
                'vehicle_id' => 1,
                'vehicle_registration_number' => 'DHK-GA-5678',
                'start_location' => 'Head Office',
                'destination' => 'Sylhet Office',
                'start_time' => Carbon::now()->subDay()->setHour(8)->setMinute(0),
                'end_time' => null,
                'distance_km' => null,
                'purpose' => 'Document Delivery',
                'fuel_cost' => 0.00,
                'total_cost' => 0.00,
                'is_locked' => 0,
                'trip_initiate_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'status' => 'initiate',
                'reject_reason' => null,
                'created_at' => Carbon::now()->subDays(2),
                'created_by' => 5,
                'updated_at' => Carbon::now()->subDays(2),
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
                'start_time' => Carbon::now()->subDays(5)->setHour(10)->setMinute(0),
                'end_time' => Carbon::now()->subDays(5)->setHour(17)->setMinute(45),
                'distance_km' => 189.20,
                'purpose' => 'Equipment Transport',
                'fuel_cost' => 2800.00,
                'total_cost' => 3200.00,
                'is_locked' => 1,
                'trip_initiate_date' => Carbon::now()->subDays(6)->format('Y-m-d'),
                'status' => 'completed',
                'reject_reason' => null,
                'created_at' => Carbon::now()->subDays(6),
                'created_by' => 6,
                'updated_at' => Carbon::now()->subDays(5)->setHour(18),
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
                'start_time' => Carbon::now()->subDays(1)->setHour(14)->setMinute(0),
                'end_time' => null,
                'distance_km' => null,
                'purpose' => 'Cargo Pickup',
                'fuel_cost' => 0.00,
                'total_cost' => 0.00,
                'is_locked' => 0,
                'trip_initiate_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'status' => 'reject',
                'reject_reason' => 'Vehicle maintenance required',
                'created_at' => Carbon::now()->subDays(2),
                'created_by' => 4,
                'updated_at' => Carbon::now()->subDay(),
                'updated_by' => 2,
            ],
        ]);
    }
} 