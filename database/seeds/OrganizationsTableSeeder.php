<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert([
            [
                'org_code' => 1001,
                'name' => 'ইস্টার্ন ইউনিভার্সিটি',
                'address' => 'University Main Campus, Academic Building',
                'org_type' => 'university',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'org_code' => 1002,
                'name' => 'Engineering Faculty',
                'address' => 'Engineering Building, Block A',
                'org_type' => 'university',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'org_code' => 1003,
                'name' => 'Medical Faculty',
                'address' => 'Medical College Building, Block B',
                'org_type' => 'college',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'org_code' => 1004,
                'name' => 'Student Hostel Complex',
                'address' => 'Residential Area, Hostel Block 1-5',
                'org_type' => 'university',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'org_code' => 1005,
                'name' => 'Administrative Building',
                'address' => 'Central Administration, Main Office',
                'org_type' => 'university',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'org_code' => 1006,
                'name' => 'Sports Complex',
                'address' => 'University Sports Complex, Stadium Road',
                'org_type' => 'university',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
} 