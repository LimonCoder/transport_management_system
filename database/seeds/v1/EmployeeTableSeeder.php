<?php

use App\Models\V1\Employee;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('employees')->delete();

		// EmployeeTableSeeder
		Employee::create([
				'org_code' => 369949,
				'designation_id' => 1,
				'name' => 'Omar Faruk' ,
				'mobile_no' =>' 01838723408',
                'image' => 'default.png'
			]);
	}
}
