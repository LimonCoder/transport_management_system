<?php

use App\Models\V1\Repairs;
use Illuminate\Database\Seeder;

class RepairsTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('repairs')->delete();

		// RepairsTableSeeder
		Repairs::create([
		    "org_code" => 369949,
            "vehicle_id" => 1,
            "employee_id" => 1,
            "damage_parts" => "enginee damage",
            "new_parts" => "new enginee intregrated",
            "total_cost" => 23000,
            "cause_of_problems" => "enginee damaged",
            "insert_date" => date('Y-m-d'),
        ]);
	}
}
