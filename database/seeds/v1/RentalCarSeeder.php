<?php

use App\Models\V1\RentalCar;
use Illuminate\Database\Seeder;

class RentalCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RentalCar::create([
            "org_code"=> 369949,
            "vehicle_id"=> 1,
            "from_date"=> '2021-06-06',
            "to_date"=> '2021-06-06',
            "total_day"=> 30,
            "amount"=> 10000.00,
            "vat"=> 150.00,
            "income_tax"=> 25.00,
            "total_amount"=> 10175,
            "insert_date" => date('Y-m-d'),
        ]);
    }
}
