<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuelTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuel_type')->insert([
            [
                'id' => 1,
                'org_code' => 1001,
                'name' => 'Petrol',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'org_code' => 1001,
                'name' => 'Diesel',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'org_code' => 1001,
                'name' => 'CNG',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'org_code' => 1001,
                'name' => 'Electric',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'org_code' => 1002,
                'name' => 'Petrol',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id' => 6,
                'org_code' => 1002,
                'name' => 'Diesel',
                'status' => 'active',
                'created_by' => 2,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }
} 