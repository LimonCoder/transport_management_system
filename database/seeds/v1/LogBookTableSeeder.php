<?php

use App\Models\V1\LogBook;
use Illuminate\Database\Seeder;

class LogBookTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('log_books')->delete();

		// row 1
		LogBook::create([
		    "org_code" => 369949,
            "driver_id" => 1,
            "vehicle_id" => 1,
            "employee_id" => 1,
            "from" => "cumilla",
            "out_time" => "14:40:07",
            "destination" => "laksam",
            "journey_time" => "15:40:07",
            "journey_cause" => "অফিসের কাজে যাচ্ছি",
            "status" => 1, // 1 = complete
            "insert_date" => date('Y-m-d')

        ]);
	}
}
