<?php

use App\Models\V1\DriverInfo;
use Illuminate\Database\Seeder;

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
