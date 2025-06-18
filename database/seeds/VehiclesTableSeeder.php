<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles')->insert([
            [
                'id' => 1,
                'org_code' => 1001,
                'registration_number' => 'DHK-METRO-1234',
                'model' => 'Toyota Hiace',
                'capacity' => 15,
                'fuel_type_id' => 2, // Diesel
                'images' => json_encode(['vehicle1_front.jpg', 'vehicle1_side.jpg']),
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
                'version' => 1,
            ],
            [
                'id' => 2,
                'org_code' => 1001,
                'registration_number' => 'DHK-GA-5678',
                'model' => 'Mahindra Bolero',
                'capacity' => 7,
                'fuel_type_id' => 2, // Diesel
                'images' => json_encode(['vehicle2_front.jpg']),
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
                'version' => 1,
            ],
            [
                'id' => 3,
                'org_code' => 1001,
                'registration_number' => 'CHT-HA-9101',
                'model' => 'Suzuki APV',
                'capacity' => 8,
                'fuel_type_id' => 1, // Petrol
                'images' => null,
                'status' => 'maintenance',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'version' => 2,
            ],
            [
                'id' => 4,
                'org_code' => 1002,
                'registration_number' => 'SYL-KA-2468',
                'model' => 'Tata Sumo',
                'capacity' => 10,
                'fuel_type_id' => 6, // Diesel for org 1002
                'images' => json_encode(['vehicle4_front.jpg', 'vehicle4_back.jpg']),
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
                'version' => 1,
            ],
            [
                'id' => 5,
                'org_code' => 1002,
                'registration_number' => 'RAJ-BA-1357',
                'model' => 'Honda CR-V',
                'capacity' => 5,
                'fuel_type_id' => 5, // Petrol for org 1002
                'images' => json_encode(['vehicle5_front.jpg']),
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => null,
                'deleted_at' => null,
                'version' => 1,
            ],
        ]);
    }
} 