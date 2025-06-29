<?php

use Illuminate\Database\Seeder;

class RoutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('routes')->insert([
            [
                'org_code' => 1001,
                'title' => 'Route A',
                'details' => 'Details of Route A',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'org_code' => 1001,
                'title' => 'Route B',
                'details' => 'Details of Route B',
                'status' => 'inactive',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
