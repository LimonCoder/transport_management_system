<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehiclesAuditLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles_audit_log')->insert([
            [
                'id' => 1,
                'primary_id' => 1,
                'org_code' => 1001,
                'registration_number' => 'DHK-METRO-1234',
                'model' => 'Toyota Hiace',
                'capacity' => 15,
                'fuel_type_id' => 2,
                'images' => json_encode(['vehicle1_front.jpg', 'vehicle1_side.jpg']),
                'status' => 'active',
                'action' => 'create',
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'id' => 2,
                'primary_id' => 2,
                'org_code' => 1001,
                'registration_number' => 'DHK-GA-5678',
                'model' => 'Mahindra Bolero',
                'capacity' => 7,
                'fuel_type_id' => 2,
                'images' => json_encode(['vehicle2_front.jpg']),
                'status' => 'active',
                'action' => 'create',
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'id' => 3,
                'primary_id' => 3,
                'org_code' => 1001,
                'registration_number' => 'CHT-HA-9101',
                'model' => 'Suzuki APV',
                'capacity' => 8,
                'fuel_type_id' => 1,
                'images' => null,
                'status' => 'active',
                'action' => 'create',
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(6),
            ],
            [
                'id' => 4,
                'primary_id' => 3,
                'org_code' => 1001,
                'registration_number' => 'CHT-HA-9101',
                'model' => 'Suzuki APV',
                'capacity' => 8,
                'fuel_type_id' => 1,
                'images' => null,
                'status' => 'maintenance',
                'action' => 'modify',
                'created_by' => 1,
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'id' => 5,
                'primary_id' => 4,
                'org_code' => 1002,
                'registration_number' => 'SYL-KA-2468',
                'model' => 'Tata Sumo',
                'capacity' => 10,
                'fuel_type_id' => 6,
                'images' => json_encode(['vehicle4_front.jpg', 'vehicle4_back.jpg']),
                'status' => 'active',
                'action' => 'create',
                'created_by' => 2,
                'created_at' => Carbon::now()->subDays(7),
            ],
        ]);
    }
} 