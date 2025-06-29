<?php

namespace seeds;

use App\Models\V2\Designation;
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
            "name" => "Operator",
        ]);
        // row 2
        Designation::create([
            "name" => "Assistance Operator",
        ]);


    }
}
