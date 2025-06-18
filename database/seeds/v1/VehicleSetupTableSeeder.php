<?php

use App\Models\V1\VehicleSetup;
use Illuminate\Database\Seeder;

class VehicleSetupTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('vehicle_setup')->delete();

		// VehicleSetupTableSeeder
		VehicleSetup::create([
		    "org_code" => 369949,
            "employee_id" => 1,
            "driver_id" => 1,
            "vehicle_reg_no" => "4575567567",
            "body_type" => "red",
            "chassis_no" => "45",
            "engine_no" => "465454",
            "develop_year" => "2012",
            "fitness_duration" => "2 years",
            "tax_token_duration" => "4 years",
            "assignment_date" => date('Y-m-d'),
            'images' => 'default.png',
            "useless_date" => null,
            "status" => 1 // 1 = running
        ]);
	}
}
