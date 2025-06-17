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
                'id' => 1,
                'org_code' => 1001,
                'driver_id' => '550e8400-e29b-41d4-a716-446655440001',
                'driver_name' => 'John Doe',
                'vehicle_id' => '550e8400-e29b-41d4-a716-446655440101',
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
                'status' => 'completed',
                'created_at' => Carbon::now()->subDays(3),
                'created_by' => 4,
                'updated_at' => Carbon::now()->subDays(2)->setHour(16),
                'updated_by' => 4,
            ],
            [
                'id' => 2,
                'org_code' => 1001,
                'driver_id' => '550e8400-e29b-41d4-a716-446655440002',
                'driver_name' => 'Jane Smith',
                'vehicle_id' => '550e8400-e29b-41d4-a716-446655440102',
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
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(2),
                'created_by' => 5,
                'updated_at' => Carbon::now()->subDays(2),
                'updated_by' => null,
            ],
            [
                'id' => 3,
                'org_code' => 1002,
                'driver_id' => '550e8400-e29b-41d4-a716-446655440003',
                'driver_name' => 'Mike Johnson',
                'vehicle_id' => '550e8400-e29b-41d4-a716-446655440103',
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
                'status' => 'completed',
                'created_at' => Carbon::now()->subDays(6),
                'created_by' => 6,
                'updated_at' => Carbon::now()->subDays(5)->setHour(18),
                'updated_by' => 6,
            ],
            [
                'id' => 4,
                'org_code' => 1001,
                'driver_id' => '550e8400-e29b-41d4-a716-446655440001',
                'driver_name' => 'John Doe',
                'vehicle_id' => '550e8400-e29b-41d4-a716-446655440103',
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
                'status' => 'cancelled',
                'created_at' => Carbon::now()->subDays(2),
                'created_by' => 4,
                'updated_at' => Carbon::now()->subDay(),
                'updated_by' => 2,
            ],
        ]);
    }
} 