<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drivers')->insert([
            [
                'id' => 1,
                'user_id' => 4, // driver1
                'org_code' => 1001,
                'name' => 'Ahmed Hassan',
                'license_number' => 'DL-001-2023-456789',
                'date_of_joining' => '2023-02-10',
                'mobile_number' => '01912345680',
                'address' => '789 Transport Road, Sylhet, Bangladesh',
                'created_by' => 2,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 5, // driver2
                'org_code' => 1001,
                'name' => 'Mohammad Rahman',
                'license_number' => 'DL-002-2023-789012',
                'date_of_joining' => '2023-04-15',
                'mobile_number' => '01612345681',
                'address' => '321 Highway Street, Rajshahi, Bangladesh',
                'created_by' => 2,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'user_id' => 6, // driver3
                'org_code' => 1001,
                'name' => 'Karim Abdullah'  ,
                'license_number' => 'DL-003-2023-345678',
                'date_of_joining' => '2023-06-01',
                'mobile_number' => '01512345682',
                'address' => '654 Fleet Avenue, Khulna, Bangladesh',
                'created_by' => 2,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 