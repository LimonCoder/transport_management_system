<?php

use Illuminate\Database\Seeder;
use App\Models\DriverInfo;

class DriverInfoTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('driver_info')->delete();

		// row 1
		DriverInfo::create([
		    "org_code" => 369949,
            "name" => "Shoikot Hossain",
            "mobile_no" => "01714893467",
            "image" => "default.png",

        ]);
		// row 2
        DriverInfo::create([
            "org_code" => 369949,
            "name" => "Bipul Kumar Sorker",
            "image" => "default.png",
        ]);

	}
}
