<?php

use Illuminate\Database\Seeder;
use App\Models\Meter;

class MeterTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('meter')->delete();

		// MeterTableSeeder
		Meter::create([
		    "org_code" => 369949,
            "vehicle_id" => 1,
            "log_book_id" => 1,
            "out_km" => 40,
            "in_km" => 100,
            "in_time" => "15:40:07",
        ]);
	}
}
