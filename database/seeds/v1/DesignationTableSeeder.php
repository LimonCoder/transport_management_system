<?php

use App\Models\V1\Designation;
use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // row 1
        Designation::create([
            "name" => "জেলা প্রশাসক",
        ]);
        // row 2
        Designation::create([
            "name" => "উপজেলা নির্বাহী অফিসার",
        ]);
    }
}
