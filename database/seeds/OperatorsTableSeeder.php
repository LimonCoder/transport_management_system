<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operators')->insert([
            [
                'id' => 1,
                'user_id' => 2, // operator1
                'org_code' => '1001',
                'name' => 'John Smith',
                'designation_id' => 1,
                'date_of_joining' => '2023-01-15',
                'mobile_number' => '01712345678',
                'address' => '123 Main Street, Dhaka, Bangladesh',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 3, // operator2
                'org_code' => '1001',
                'name' => 'Sarah Johnson',
                'designation_id' => 2,
                'date_of_joining' => '2023-03-20',
                'mobile_number' => '01812345697',
                'address' => '456 Oak Avenue, Chittagong, Bangladesh',
                'created_by' => 2,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'user_id' => 4, // operator1
                'org_code' => '1002',
                'name' => 'Sarah Johnson',
                'designation_id' => 1,
                'date_of_joining' => '2023-03-20',
                'mobile_number' => '01812345679',
                'address' => '456 Oak Avenue, Chittagong, Bangladesh',
                'created_by' => 2,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 