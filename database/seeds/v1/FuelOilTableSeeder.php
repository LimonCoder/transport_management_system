<?php

use Illuminate\Database\Seeder;
use App\Models\FuelOil;

class FuelOilTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('fuel_oil')->delete();

		// FuelOilTableSeeder
		FuelOil::create([
		    "org_code" => 369949,
            "vehicle_id" => 1,
            "log_book_id" => 1,
            "type" => 1,
            "previous_stock"=>0,
            "in"=> 30,
            "out" => 17,
            "payment" => 600.00,
        ]);
	}
}
