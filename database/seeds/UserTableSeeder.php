<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use \Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        //DB::table('users')->delete();

        // row 1
        User::create([
            'org_code' => 369949,
            'employee_id' => 1,
            'username' => 'faruk_apps',
            'password' => Hash::make('0987654321'),
            'type' => 2, // 2 = admin
        ]);
        // row 2
        User::create([
            'org_code' => null,
            'employee_id' => null,
            'username' => 'super_admin',
            'password' => Hash::make('INNOVATIONIT2021'),
            'type' => 1, // 1 = super_admin
        ]);
    }
}
