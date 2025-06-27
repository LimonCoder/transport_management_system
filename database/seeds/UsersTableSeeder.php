<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'role_id' => 1,
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'user_type' => 'system-admin',
                'org_code' => null,
                'version' => 1,
                'is_special_user' => 0,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'role_id' => 2,
                'username' => 'operator1',
                'password' => Hash::make('operator123'),
                'user_type' => 'operator',
                'org_code' => '1001',
                'is_special_user' => '1',
                'version' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'role_id' => 2,
                'username' => 'operator2',
                'password' => Hash::make('operator123'),
                'user_type' => 'operator',
                'org_code' => '1001',
                'version' => 1,
                'created_by' => 1,
                'is_special_user' => '0',
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'role_id' => 2,
                'username' => 'operator3',
                'password' => Hash::make('operator123'),
                'user_type' => 'operator',
                'org_code' => '1002',
                'version' => 1,
                'is_special_user' => '1',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'role_id' => 3,
                'username' => 'driver1',
                'password' => Hash::make('driver123'),
                'user_type' => 'driver',
                'org_code' => '1001',
                'version' => 1,
                'created_by' => 1,
                'is_special_user' => '0',
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'role_id' => 3,
                'username' => 'driver2',
                'password' => Hash::make('driver123'),
                'user_type' => 'driver',
                'org_code' => '1002',
                'version' => 1,
                'created_by' => 1,
                'is_special_user' => '0',
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'role_id' => 3,
                'username' => 'driver3',
                'password' => Hash::make('driver123'),
                'user_type' => 'driver',
                'org_code' => '1001',
                'version' => 1,
                'created_by' => 1,
                'is_special_user' => '0',
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 